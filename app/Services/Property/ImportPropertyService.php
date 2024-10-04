<?php

namespace App\Services\Property;

use App\Constants\CurrencyConstants;
use App\Constants\PropertyConstants;
use App\Models\PropertyCategory;
use App\Models\PropertyFile;
use App\Services\Finance\CurrencyService;
use App\Services\Media\FileService;
use Illuminate\Http\UploadedFile;

class ImportPropertyService
{
    public static function importProperties(array $data)
    {
        $property = self::createProperty($data);
        $features = ["bedroom" => $property->bedrooms, "bathroom" => $property->bathrooms];
        self::parseFeatures($features, $property->id);
        self::parseTimelines($data["funding_timeline"] ?? null, $property);
        // self::processImage($data, $property);
    }

    public static function createProperty(array $data)
    {
        $name = $data["name"] ?? null;
        $location = $data["location"] ?? null;
        $address = $data["location"] ?? null;
        $sqft = $data["area_sq_ft"] ?? null;
        $average_occupancy = $data["average_occupancy"] ?? null;
        $projected_annual_yield = $data["projected_annual_yield"] ?? null;
        $description = $data["property_overview"] ?? null;
        $price = $data["property_cost"] ?? null;
        $maihomm_fee = $data["maihomm_fee"] ?? null;
        $legal_and_closing_cost = $data["legal_and_closing_cost"] ?? null;
        $property_acq_cost = $data["property_acquisition_cost"] ?? null;
        $per_slot = $data["property_costslot_ownership_cost_120"] ?? null;


        $one_time_payment_per_slot = $data["one_time_paymentslot"] ?? null;
        $rental_cost_per_night = $data["rental_costnight"] ?? null;


        $projected_gross_rent = $data["projected_gross_rent_income"] ?? null;
        $management_fees = $data["maihomm_management_annual_fees"] ?? null;

        $service_charge = $data["service_charge_utillity_bills_and_taxes"] ?? null;
        $projected_annual_net_rental_income = $data["projected_annual_net_rental_income"] ?? null;
        $projected_annual_rental_income_per_slot = $data["projected_annual_rental_incomeslot"] ?? null;

        $first_year_projection = $data["first_year_projection"] ?? null;
        $fifth_year_projection = $data["fifth_year_projection"] ?? null;
        $tenth_year_projection = $data["tenth_year_projection"] ?? null;
        $bedroom = explode(" ", $data["bedrooms"])[0] ?? null;
        $bathroom = explode(" ", $data["bathrooms"])[0] ?? null;
        $status = $data["status"] ?? null;

        $category_id = PropertyCategory::where("uuid", "residential")->first()->id;

        $currency = self::getCurrency($data);

        $property = PropertyService::create([
            "name" => $name,
            "location" => $location,
            "address" => $address,
            "currency_id" => $currency->id,
            "price" => $price ?? 1,
            "bedrooms" => $bedroom,
            "bathrooms" => $bathroom,
            "maihomm_fee" => $maihomm_fee,
            "sqft" => $sqft,
            "average_occupancy" => $average_occupancy,
            "projected_annual_yield" => $projected_annual_yield,
            "description" => $description,
            "legal_and_closing_cost" => $legal_and_closing_cost,
            "property_acq_cost" => $property_acq_cost,
            "per_slot" => $per_slot,
            "projected_gross_rent" => $projected_gross_rent,
            "management_fees" => $management_fees,
            "service_charge" => $service_charge,
            "one_time_payment_per_slot" => $one_time_payment_per_slot,
            "rental_cost_per_night" => $rental_cost_per_night,
            "projected_annual_net_rental_income" => $projected_annual_net_rental_income,
            "projected_annual_rental_income_per_slot" => $projected_annual_rental_income_per_slot,
            "first_year_projection" => remove_formatted_money($first_year_projection),
            "fifth_year_projection" => remove_formatted_money($fifth_year_projection),
            "tenth_year_projection" => remove_formatted_money($tenth_year_projection),
            "category_id" => $category_id,
            "created_by" => auth()->id(),
            "status" => $status ?? PropertyConstants::STATUS_AVAILABLE
        ]);

        return $property;
    }

    private static function getCurrency($data)
    {
        if ($data["currency"] == "Pound") {
            $currency = CurrencyService::getByType(CurrencyConstants::POUND_CURRENCY);
        }

        if ($data["currency"] == "Euro") {
            $currency = CurrencyService::getByType(CurrencyConstants::EURO_CURRENCY);
        }

        if ($data["currency"] == "Dollar") {
            $currency = CurrencyService::getByType(CurrencyConstants::DOLLAR_CURRENCY);
        }

        return $currency;
    }

    private static function parseFeatures($raw_features, $property_id)
    {
        foreach ($raw_features as $key => $value) {
            $title = $key;

            if ($title == 'bedroom') {
                $icon = PropertyConstants::ICON_OPTIONS["bedroom"];
            } elseif ($title == 'bathroom') {
                $icon = PropertyConstants::ICON_OPTIONS["bathroom"];
            }

            PropertySpecificationService::save([
                "property_id" => $property_id,
                "title" => ucfirst($title),
                "key" => slugify($title),
                "value" => (string) $value,
                "group" => "Features",
                "metadata" => json_encode([
                    "icon" => $icon ?? null
                ])
            ]);
        }
    }

    public static function parseTimelines(?string $raw_timelines, $property)
    {
        if (!empty($raw_timelines)) {
            $timeline_array = explode(",", $raw_timelines);
            foreach ($timeline_array as $timeline) {
                $array = explode(":", $timeline);
                $key = slugify($array[0]);

                if ($key == slugify('Closing date')) {
                    $icon = PropertyConstants::ICON_OPTIONS["closing-date"];
                } else if ($key == slugify('Properties purchase closing and title deeds distribution')) {
                    $icon = PropertyConstants::ICON_OPTIONS["hand-holding-usd"];
                } else if ($key == slugify('Handover to property manager')) {
                    $icon = PropertyConstants::ICON_OPTIONS["users"];
                } else if ($key == slugify('Expected first rental payment')) {
                    $icon = PropertyConstants::ICON_OPTIONS["money-bill"];
                }

                PropertySpecificationService::save([
                    "property_id" => $property->id,
                    "title" => $array[0],
                    "key" => slugify($array[0]),
                    "value" => $array[1],
                    "group" => "Timelines",
                    "metadata" => json_encode([
                        "icon" => $icon ?? null
                    ])
                ]);
            }
        }
    }

    public static function processImage(array $data, $property)
    {
        $array = [
            "featured_image" ?? null,
            "supporting_image_1",
            "supporting_image_2",
            "supporting_image_3",
            "supporting_image_4",
            "supporting_image_5",
            "supporting_image_6",
        ];

        foreach ($array as $key) {
            $value = $data[$key];
            $img = downloadFileFromUrl($value, storage_path("app/media/property_image"));

            if (!empty($img)) {
                $form_file = new UploadedFile(storage_path("app/media/property_image/$img"), "$img");

                if (!empty($logo = $form_file ?? null)) {
                    $fileService = new FileService;
                    $savedFile = $fileService->saveFromFile($logo, "property_image", null, null);
                    $data["file_id"] = $savedFile->id;
                    $data["type"] = self::getFileType(storage_path($savedFile->path));
                }

                $property_file =  self::createPropertyFile($property, $data["file_id"], $data["type"], $key == "featured_image");

                if ($property_file->is_default == 1) {
                    self::updatePropertyFile($property_file, $data["type"]);
                }
            }
        }
    }

    private static function createPropertyFile($property, $file_id, $type, $isDefault)
    {
        return PropertyFile::create([
            "property_id" => $property->id,
            "file_id" => $file_id,
            "type" => $type,
            "is_default" => $isDefault ? 1 : 0
        ]);
    }

    private static function updatePropertyFile($property_file, $type)
    {
        PropertyFile::whereNotIn("id", [$property_file->id])
            ->where("property_id", $property_file->property_id)
            ->where("type", $type)
            ->update([
                "is_default" => 0
            ]);
    }


    public static function getFileType($file)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($fileInfo, $file);
        finfo_close($fileInfo);
        $image_type = explode(",", imageMimes());
        $video_type = explode(",", videoMimes());

        switch ($type) {
            case in_array($type, array_merge($image_type, $video_type)):
                $type = strtok($type, '/');
                break;

            case $type == "application/pdf":
                $type = explode("/", $type)[1];
                break;
            default:
                $val = implode(".", array_slice(explode(".", $type), -2));
                if ($val == "spreadsheetml.sheet") {
                    $type = "sheet_document";
                } else if ($val == "wordprocessingml.document") {
                    $type = "word_document";
                }
                break;
        };

        return $type;
    }
}

<?php

namespace App\Services\Property;

use App\Constants\AppConstants;
use App\Constants\PropertyConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Property\PropertyException;
use App\Models\Favorite;
use App\Models\Payout;
use App\Models\Property;
use App\Models\PropertyFile;
use App\Models\PropertySpecification;
use App\QueryBuilders\General\PropertyQueryBuilder;
use App\Services\Media\FileService;
use App\Services\Notifications\AppMailerService;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PropertyService
{
    const FILE_VIDEO = "video";
    const FILE_IMAGE = "image";
    const FILE_TYPES = [
        self::FILE_VIDEO,
        self::FILE_IMAGE
    ];
    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "status" => "nullable|string|" . Rule::in(PropertyConstants::STATUS_OPTIONS) . "|" . Rule::requiredIf(empty($id)),
            "name" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "description" => "nullable|string",
            "price" => "nullable|numeric|gt:0|" . Rule::requiredIf(empty($id)),
            "sqft" => "nullable|numeric|gt:-1",
            "bedrooms" => "nullable|numeric|gt:-1",
            "bathrooms" => "nullable|numeric|gt:-1",
            "address" => "nullable|string",
            "landmark" => "nullable|string",
            "country_id" => "nullable",
            "state_id" => "nullable",
            "closing_date" => "nullable",
            "city_id" => "nullable",
            "currency_id" => "nullable|exists:currencies,id|" . Rule::requiredIf(empty($id)),
            "amenity_ids" => "nullable|array",
            "amenity_ids.*" => "required|exists:amenities,id",
            "images" => "nullable|array",
            "videos" => "nullable|array",
            'images.*' => 'nullable|mimes:webp,jpeg,png,jpg,svg|max:2048',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            "created_by" => "nullable|exists:users,id|" . Rule::requiredIf(empty($id)),
            "first_year_projection" => "nullable|numeric|gt:-1",
            "fifth_year_projection" => "nullable|numeric|gt:-1",
            "tenth_year_projection" => "nullable|numeric|gt:-1",
            "legal_and_closing_cost" => "nullable|numeric|gt:-1",
            "per_slot" => "nullable|numeric|gt:-1",
            "total_sold" => "nullable|numeric|gt:-1",
            "total_slots" => "nullable|numeric|gt:-1",
            "property_acq_cost" => "nullable|numeric|gt:-1",
            "service_charge" => "nullable|numeric|gt:-1",
            "maihomm_fee" => "nullable|numeric|gt:-1",
            "management_fees" => "nullable|numeric|gt:-1",
            "projected_gross_rent" => "nullable|numeric|gt:-1",
            "one_time_payment_per_slot" => "nullable|numeric|gt:-1",
            "rental_cost_per_night" => "nullable|numeric|gt:-1",
            "projected_annual_yield" => "nullable|numeric|gt:-1",
            "projected_annual_yield_subtext" => "nullable|string",
            "average_occupancy" => "nullable|numeric|gt:-1",
            "projected_annual_net_rental_income" => "nullable|numeric|gt:-1",
            "projected_annual_rental_income_per_slot" => "nullable|numeric|gt:-1",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function create(array $data): Property
    {
        DB::beginTransaction();
        try {
            $price = $data["price"];
            $maihomm_fee = $data["maihomm_fee"] ?? 0;
            $legal_and_closing_cost = $data["legal_and_closing_cost"] ?? 0;
            $data["property_acq_cost"] = $price + $maihomm_fee + $legal_and_closing_cost;
            $data = self::validate($data);
            $data["uuid"] = self::generateUuid();
            $images = $data["images"] ?? null;
            $videos = $data["videos"] ?? null;
            $amenity_ids = $data["amenity_ids"] ?? null;
            unset($data["images"]);
            unset($data["videos"]);
            unset($data["amenity_ids"]);
            $data["total_sold"] = 6; //Auto reserve 6 slots
            $property = Property::create($data);
            if (!empty($images)) {
                foreach ($images as $image) {
                    $type = "image";
                    $fileService = new FileService;
                    $file = $fileService->setMoveFile(true)->saveFromFile($image, "property/images");
                    PropertyImageService::create($property, $file["id"], $type);
                }
            }
            if (!empty($videos)) {
                foreach ($videos as $video) {
                    $type = "video";
                    $fileService = new FileService;
                    $file = $fileService->setMoveFile(true)->saveFromFile($video, "property/videos");
                    PropertyImageService::create($property, $file["id"], $type);
                }
            }

            if (!empty($amenity_ids)) {
                self::saveAmenities($property, $amenity_ids);
            }

            DB::commit();
            return $property;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public static function saveAmenities(Property $property, $amenity_ids)
    {
        $property->amenities()->delete();
        foreach ($amenity_ids as $id) {
            $property->amenities()->create([
                "property_id" => $property->id,
                "amenity_id" => $id
            ]);
        }
    }
    public static function update(array $data, $id): Property
    {
        DB::beginTransaction();
        try {
            $data = self::validate($data, $id);
            $images = $data["images"] ?? null;
            $videos = $data["videos"] ?? null;
            $amenity_ids = $data["amenity_ids"] ?? null;
            unset($data["images"]);
            unset($data["videos"]);
            unset($data["amenity_ids"]);
            $property = Property::find($id);
            if (empty($property)) {
                throw new PropertyException("Property not found");
            }
            if (!empty($images ?? null)) {
                foreach ($images as $image) {
                    $type = "image";
                    $fileService = new FileService;
                    $file = $fileService->setMoveFile(true)->saveFromFile($image, "property/images");
                    PropertyImageService::create($property, $file["id"], $type);
                }
            }
            if (!empty($videos ?? null)) {
                foreach ($videos as $video) {
                    $type = "video";
                    $fileService = new FileService;
                    $file = $fileService->setMoveFile(true)->saveFromFile($video, "property/videos");
                    PropertyImageService::create($property, $file["id"], $type);
                }
            }

            if (!empty($amenity_ids)) {
                self::saveAmenities($property, $amenity_ids);
            }
            $property->update($data);

            DB::commit();
            return $property;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function computeValues(array $data)
    {
        return [
            "maihomm_fee" => null
        ];
    }
    public static function filesValidation(array $data)
    {
        $validator = Validator::make($data, [
            "images" => "nullable|array",
            "videos" => "nullable|array",
            'images.*' => 'nullable|mimes:webp,jpeg,png,jpg,svg|max:2048',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }
    public static function uploadPropertyFiles(array $data, $property_id)
    {
        $data = self::filesValidation($data);
        $images = $data["images"] ?? null;
        $videos = $data["videos"] ?? null;
        unset($data["images"]);
        unset($data["videos"]);
        $property = Property::with("files")->find($property_id);
        if (!empty($images ?? null)) {
            foreach ($images as $image) {
                $type = "image";
                $fileService = new FileService;
                $file = $fileService->setMoveFile(true)->saveFromFile($image, "property/images");
                PropertyImageService::create($property, $file["id"], $type);
            }
        }
        if (!empty($videos ?? null)) {
            foreach ($videos as $video) {
                $type = "video";
                $fileService = new FileService;
                $file = $fileService->setMoveFile(true)->saveFromFile($video, "property/videos");
                PropertyImageService::create($property, $file["id"], $type);
            }
        }
        $property->update($data);
        return $property;
    }
    public static function changeSinglePropertyFile(array $data, $image_id)
    {
        $property_image = PropertyFile::with("property")->find($image_id);
        $validation = ($property_image->type == "image") ? "image" : "mimetypes:" . videoMimes();
        $validator = Validator::make($data, [
            "order" => "nullable|numeric|gt:0",
            "file" => "nullable|" . $validation
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        };
        $data = $validator->validated();

        if (!empty($file = $data["file"] ?? null)) {
            unset($data["file"]);
            if ($property_image->type == "image") {
                $fileService = new FileService;
                $file = $fileService->setMoveFile(true)->saveFromFile($file, "property/images", $property_image->file->id);
            }
            if ($property_image->type == "video") {
                $fileService = new FileService;
                $file = $fileService->setMoveFile(true)->saveFromFile($file, "property/videos", $property_image->file->id);
            }
            $data["file_id"] = $file->id;
        }
        $property_image->update($data);
        return $property_image;
    }
    public static function deleteSinglePropertyFile($file_id)
    {
        $property_file = PropertyFile::findOrFail($file_id);
        $file = $property_file?->file;
        $property_file->delete();
        $file?->cleanDelete();
    }

    public static function deleteFiles($property_id, array $file_ids)
    {
        $files = PropertyFile::where("property_id" , $property_id)
        ->whereIn("id",$file_ids)->get();
        foreach ($files as $property_file) {
            $file = $property_file?->file;
            $property_file->delete();
            $file?->cleanDelete();

        }
    }

    public function updateFeatureSpecifications(Property $property)
    {
        $specs = [
            [
                'group' => "Features",
                'title' => "Sqft",
                'key' => "sqft",
                'value' => $property->sqft,
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["price"]
                ])
            ],
            [
                'group' => "Features",
                'title' => "Bedrooms",
                'key' => "bedrooms",
                'value' => $property->bedrooms,
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["bedroom"]
                ])
            ],
            [
                'group' => "Features",
                'title' => "bathrooms",
                'key' => "bathrooms",
                'value' => $property->bathrooms,
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["bathroom"]
                ])
            ],
        ];

        foreach ($specs as $spec) {
            PropertySpecification::updateOrCreate([
                'property_id' => $property->id,
            ], $spec);
        }
    }

    public static function delete($id, $force = false): void
    {
        $property = Property::findOrFail($id);
        if (!$force) {
            $property->update([
                "status" => StatusConstants::INACTIVE,
                "deleted_at" => now()
            ]);
            return;
        }
        if (!empty($files = $property->files)) {
            foreach ($files as $file) {
                $file->delete();
                deleteFileFromPrivateStorage($file->file->path);
                $file->file->delete();
            }
        }
        $property->specifications()->delete();
        $property->savedProperties()->delete();
        $property->forceDelete();
    }

    public static function generateUuid()
    {
        $key = getRandomToken(6);
        $check = Property::where("uuid", $key)->count();
        if ($check > 0) {
            return self::generateUuid();
        }
        return $key;
    }


    public static function getByUuid($uuid)
    {
        $profile = Property::where("uuid", $uuid)->first();

        if (empty($profile)) {
            throw new PropertyException("Property not found", 404);
        }
        return $profile;
    }

    public static function geocodeAddress($property)
    {
        try {
            $address = $property->address;
            $client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org/']);
            $response = $client->request('GET', 'search', [
                'query' => [
                    'q' => $address,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'limit' => 1
                ]
            ]);
            $data = json_decode($response->getBody());

            if (!empty($data)) {
                $location = [
                    'lat' => (float) $data[0]->lat,
                    'lng' => (float) $data[0]->lon
                ];

                return $location;
            }
        } catch (\Throwable $th) {
            return [
                "lat" => "37.4217636",
                "lng" => "-122.084614"
            ];
        }
    }

    public static function filterFilesByType($collections, $type)
    {
        return $collections->filter(function ($file) use ($type) {
            if (is_array($type)) {
                return in_array($file->type, $type);
            } else {
                return $file->type == $type;
            }
        });
    }

    public static function getRelatedProperties($request, $property_id): LengthAwarePaginator
    {
        $property = Property::find($property_id);

        $related_properties = PropertyQueryBuilder::filterIndex($request)
            ->whereNotIn("id", [$property_id])
            ->where("category_id", $property->category_id)
            ->paginate();
        return $related_properties;
    }

    public static function addToFavorites($property_id)
    {
        return Favorite::firstOrCreate([
            "property_id" => $property_id,
            "user_id" => auth()->id(),
        ]);
    }

    public static function sell(array $data)
    {
        $validator = Validator::make($data, [
            "property_id" => "required|exists:properties,id"
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $data = $validator->validated();

        $property_id = $data["property_id"];
        $property = Property::find($property_id);
        $payout_reference = getRandomToken(8);
        Payout::create([
            "property_id" => $data["property_id"],
            "amount" => $property->price,
            "status" => StatusConstants::PENDING,
            "reference" => $payout_reference
        ]);
        $property_owner = $property->owner;
        $admin_email = AppConstants::SUDO_EMAIL;
        AppMailerService::send([
            "data" => [
                "owner" => $property_owner,
                "property" => $property
            ],
            "to" => $property_owner->email,
            "template" => "emails.property.sale.owner",
            "subject" => "Property Sale",
        ]);

        AppMailerService::send([
            "data" => [
                "owner" => $property_owner,
                "property" => $property
            ],
            "to" => $admin_email,
            "template" => "emails.property.sale.admin",
            "subject" => "Property Sale Request",
        ]);
    }
    public static function propertyOwner()
    {
        return Property::where("created_by", auth()->id())->get();
    }
}

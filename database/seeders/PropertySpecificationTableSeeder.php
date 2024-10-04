<?php

namespace Database\Seeders;

use App\Constants\PropertyConstants;
use App\Models\Property;
use App\Models\PropertySpecification;
use Illuminate\Database\Seeder;

class PropertySpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $properties = Property::get();
        $specs = [
            [
                'group' => "Features",
                'title' => "Sqft",
                'key' => "sqft",
                'value' => "100",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["price"]
                ])
            ],
            [
                'group' => "Features",
                'title' => "Bedrooms",
                'key' => "bedrooms",
                'value' => "2",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["bedroom"]
                ])
            ],
            [
                'group' => "Features",
                'title' => "bathrooms",
                'key' => "bathrooms",
                'value' => "2",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["bathroom"]
                ])
            ],
            [
                'group' => "Amenities",
                'title' => "Balcony",
                'key' => "Balcony",
                'value' => "2",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["check"]
                ])
            ],

            [
                'group' => "Amenities",
                'title' => "Fireplace",
                'key' => "Fireplace",
                'value' => "1",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["check"]
                ])
            ],

            [
                'group' => "Amenities",
                'title' => "Basement",
                'key' => "Basement",
                'value' => "Basement",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["check"]
                ])
            ],

            [
                'group' => "Timelines",
                'title' => "Closing date",
                'key' => slugify("Closing date"),
                'value' => "1st of March 2023",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["closing-date"]
                ])
            ],

            [
                'group' => "Timelines",
                'title' => "Properties purchase closing and title deeds distribution",
                'key' => slugify("Properties purchase closing and title deeds distribution"),
                'value' => "1 month after closing date",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["hand-holding-usd"]
                ])
            ],

            [
                'group' => "Timelines",
                'title' => "Handover to property manager",
                'key' => slugify("Handover to property manager"),
                'value' => "1 month after property purchase",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["users"]
                ])
            ],

            [
                'group' => "Timelines",
                'title' => "Expected first rental payment",
                'key' => slugify("Expected first rental payment"),
                'value' => "1st of June 2023",
                "metadata" => json_encode([
                    "icon" => PropertyConstants::ICON_OPTIONS["money-bill"]
                ])
            ],

        ];

        foreach ($properties as $key => $property) {
            foreach ($specs as $spec) {
                PropertySpecification::create(array_merge([
                    'property_id' => $property->id,
                ], $spec));
            }
        }

        // foreach ($specs as $spec) {
        //     PropertySpecification::updateOrCreate([
        //         'property_id' => $property->id,
        //     ] , $spec);
        // }
    }
}

<?php

namespace App\Http\Resources\Properties;

use App\Constants\PropertyConstants;
use App\Services\Property\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertiesResourceCollection extends ResourceCollection
{
    public $property_files;
    public function __construct($collection, $property_files = null)
    {
        $this->collection = $collection;
        $this->property_files = $property_files;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count' =>  $this->collection->count(),
            'properties' => $this->collection->map(function ($property) {

                $images = PropertyService::filterFilesByType($this->property_files, PropertyConstants::IMAGE)
                    ->where("property_id", $property->id);
                $videos = PropertyService::filterFilesByType($this->property_files, PropertyConstants::VIDEO)
                    ->where("property_id", $property->id);

                return [
                    'id' => $property->id,
                    'name' => $property->name,
                    'costings' => [
                        'price' => $property->price,
                        'maihomm_fee' => $property->maihomm_fee,
                    ],
                    "features" => [
                        "sqft" => $property->sqft,
                        "bedrooms" => $property->bedrooms,
                        "bathrooms" => $property->bathrooms,
                    ],
                ];
                    "location" => [
                        "country" => optional($property->country)->name,
                        "state" => optional($property->state)->name,
                        "city" => optional($property->city)->name,
                        "address" => $property->address,
                    ];
                    "files" => [
                        "images" => [
                            "count" => $images->count(),
                            "default" => $property->getDefaultImage(),
                            // "others" =>
                        ],
                        "videos" => [
                            "count" => $videos->count(),
                            "others" => json_decode("{}")
                        ],
                    ];
                    'is_saved' => $property->isSavedProperty(),
                    'status' => $property->status,
                    'created_at' => $property->created_at,
                ];
            }),
        ];
    }
}

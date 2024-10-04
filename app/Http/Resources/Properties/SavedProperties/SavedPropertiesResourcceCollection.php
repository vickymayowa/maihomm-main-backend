<?php

namespace App\Http\Resources\Properties\SavedProperties;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SavedPropertiesResourcceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count' =>  $this->collection->count(),
            'saved_properties' => $this->collection->map(function ($saved_property) {
                return [
                    'id' => $saved_property->id,
                    'name' => $saved_property->property->name,
                    'costings' => [
                        'price' => $saved_property->property->price,
                        'maihomm_fee' => $saved_property->property->maihomm_fee,
                    ],
                    "features" => [
                        "sqft" => $saved_property->property->sqft,
                        "bedrooms" => $saved_property->property->bedrooms,
                        "bathrooms" => $saved_property->property->bathrooms,
                    ],
                    "location" => [
                        "country" => optional($saved_property->property->country)->name,
                        "state" => optional($saved_property->property->state)->name,
                        "city" => optional($saved_property->property->city)->name,
                        "address" => $saved_property->property->address,
                    ],
                    'status' => $saved_property->property->status,
                    'created_at' => $saved_property->property->created_at,
                ];
            }),
        ];
    }
}

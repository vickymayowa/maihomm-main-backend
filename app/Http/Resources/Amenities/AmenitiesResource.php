<?php

namespace App\Http\Resources\Amenities;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "icon" => $this->icon?->url()
        ];
    }
}

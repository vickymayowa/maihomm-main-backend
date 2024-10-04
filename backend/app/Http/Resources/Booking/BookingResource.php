<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Properties\PropertyResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isLoaded = $this->relationLoaded("user");
        return [
            "id" => $this->id,
            "user" => ($isLoaded == true) ? UserResource::make($this->user) : null,
            "property" => PropertyResource::make($this->property),
            "reference" => $this->reference,
            "check_in" => $this->check_in,
            "check_out" => $this->check_out,
            "number_of_guests" => $this->number_of_guests,
            "total_price" => $this->total_price,
            // "habitable_days" => $this->habitable_days,
            // "habitable_days_usage" => $this->habitable_days_usage,
            "service_fee" => $this->service_fee,
            "status" => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}

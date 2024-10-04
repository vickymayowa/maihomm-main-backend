<?php

namespace App\Http\Resources\Properties;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isLoaded = $this->relationLoaded("files");
        return [
            "id" => (int) $this->id,
            "name" => $this->name,
            "description" => removeStripTags($this->description ?? ""),
            "financial_summary" => [
                "first_year" => $this->first_year_projection,
                "fifth_year" => $this->fifth_year_projection,
                "tenth_year" => $this->tenth_year_projection,
            ],
            "costings" => [
                "price" => $this->price,
                "maihomm_fee" => $this->maihomm_fee,
                "legal_and_closing_cost" => $this->legal_and_closing_cost,
                "per_Slot" => $this->per_slot,
                "total_slot" => $this->total_slots,
                "total_sold" => $this->total_sold,
                "available_slots" => $this->total_slots - $this->total_slod,
                "property_acq_cost" => $this->property_acq_cost,
                "service_charge" => $this->service_charge,
                "management_fees" => $this->management_fees,
                "projected_gross_rent" => $this->projected_gross_rent,
                "one_time_payment_per_slot" => $this->one_time_payment_per_slot,
                "rental_cost_per_night" => $this->rental_cost_per_night,
                "projected_annual_yield" => $this->projected_annual_yield,
                "projected_annual_yield_subtext" => $this->projected_annual_yield_subtext,
                "average_occupancy" => $this->average_occupancy,
                "projected_annual_net_rental_income" => $this->projected_annual_net_rental_income,
                "projected_annual_rental_income_per_slot" => $this->projected_annual_rental_income_per_slot,
            ],
            "impressions" => [
                "total_views" => $this->total_views,
                "total_reviews" => $this->total_reviews,
                "total_clicks" => $this->total_clicks,
                "total_sold" => $this->total_sold,
            ],
            "location" => [
                "country" => optional($this->country)->name,
                "state" => optional($this->state)->name,
                "city" => optional($this->city)->name,
                "address" => $this->address,
            ],
            "features" => [
                "sqft" => $this->sqft,
                "bedrooms" => $this->bedrooms,
                "bathrooms" => $this->bathrooms,
            ],
            "default_image" => PropertyFilesResource::make($this->whenLoaded("defaultImage" , $this->defaultImage)),
            "files" => ($isLoaded == true) ? PropertyFilesResource::collection($this->files) : null,
            "status" => $this->status,
            "amenities" => PropertyAmenityResource::collection($this->amenities),
        ];
    }
}

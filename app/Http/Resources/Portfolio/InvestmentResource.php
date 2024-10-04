<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\Properties\PropertyResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isLoaded = $this->relationLoaded("user");
        return [
            "property" => new PropertyResource($this->whenLoaded("property", $this->property)),
            "user" => ($isLoaded == true) ? UserResource::make($this->user) : null,
            "description" => $this->description,
            "value" => $this->value,
            "term_in_month" => $this->term_in_month,
            "rate" => $this->rate,
            "investment_cost" => $this->investment_cost,
            "slots" => $this->slots,
            "roi" => $this->roi,
            "start_date" => $this->start_date,
            "maturity_date" => $this->maturity,
            "status" => $this->status,
            "created_at" => $this->created_at
        ];
    }
}

<?php

namespace App\Http\Resources\Payout;

use App\Http\Resources\Properties\PropertyResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutResource extends JsonResource
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
            "property_name" => $this->property->name,
            "reference" => $this->reference,
            "amount" => $this->amount,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->created_at
        ];
    }
}

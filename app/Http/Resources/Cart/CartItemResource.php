<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Properties\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            "property" => PropertyResource::make($this->property),
            "quantity" => $this->quantity,
            "price" => $this->price,
        ];
    }
}

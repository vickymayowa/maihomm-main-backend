<?php

namespace App\Http\Resources\Referral;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralResource extends JsonResource
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
            "referrer" => UserResource::make($this->referrer),
            "user" => UserResource::make($this->user),
            "currency" => $this->currency->name,
            "bonus" => $this->bonus,
            "created_at" => $this->created_at
        ];
    }
}

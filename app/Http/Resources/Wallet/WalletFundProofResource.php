<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletFundProofResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isLoaded = $this->relationLoaded("wallet");
        return [
            "id" => $this->id,
            "wallet" => ($isLoaded == true) ? WalletResource::make($this->wallet) : null,
            "amount" => $this->amount,
            "image" => $this->file->url(),
            "status" => $this->status,
            "uploaded_at" => $this->created_at
        ];
    }
}

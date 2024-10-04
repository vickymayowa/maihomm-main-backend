<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            "currency" => $this->currency->name,
            "balance" => $this->balance,
            "locked_balance" => $this->locked_balance,
            "total_credit" => $this->total_credit,
            "total_debit" => $this->total_debit,
        ];
    }
}

<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "min_deposit" => $this->min_deposit,
            "max_deposit" => $this->max_deposit,
            "min_withdrawal" => $this->min_withdrawal,
            "max_withdrawal" => $this->max_withdrawal,
            "allow_naira" => (bool) $this->allow_naira,
            "allow_pound" => (bool) $this->allow_pound,
            "allow_dollar" => (bool) $this->allow_dollar,
            "is_cash" => (bool) $this->is_cash,
            "is_paystack" => (bool) $this->is_paystack,
            "is_flutterwave" => (bool) $this->is_flutterwave,
        ];
    }
}

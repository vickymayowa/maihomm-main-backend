<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "monthly_income" => $this->monthly_income,
            "total_income" => $this->total_income,
            "value_appreciation" => $this->value_appreciation,
            "income_amount" => 0,
            "eligibility_loan_amount" => (double) $this->loanEligibilityCalculator()
        ];
    }
}

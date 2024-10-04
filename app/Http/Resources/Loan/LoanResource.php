<?php

namespace App\Http\Resources\Loan;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            "amount" => $this->amount,
            "eligible_loan_amount" => $this->eligible_amount,
            "status" => $this->status,
            "reference" => $this->reference,
            // "user" => new UserResource($this->whenLoaded("user", $this->user)),
            "created_at" => $this->created_at
        ];
    }
}

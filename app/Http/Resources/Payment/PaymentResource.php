<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\FileResource;
use App\Http\Resources\Portfolio\InvestmentResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "user" => UserResource::make($this->user),
            "currency" => $this->currency->name,
            "reference" => $this->reference,
            "discount" => $this->discount,
            "amount" => $this->amount,
            "fee" => $this->fee,
            "status" => $this->status,
            "investments_count" => $this->whenNotNull($this->investments_count),
            "files_count" => $this->whenNotNull($this->files_count),
            "files" => FileResource::collection($this->whenLoaded("files")),
            "investments" => InvestmentResource::collection($this->whenLoaded("investments")),
            "gateway" => $this->gateway,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}

<?php

namespace App\Http\Resources\Support;

use App\Http\Resources\Properties\PropertyResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
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
            "user" => UserResource::make($this->user) ?? null,
            "category" => $this->category,
            "priority" => $this->priority,
            "title" => $this->title,
            "message" => $this->message,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->created_at
        ];
    }
}

<?php

namespace App\Http\Resources\Properties;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            "user" => $this->user->full_name,
            "comment" => $this->comment,
            "likes" => (int) $this->likes_count,
            "rating" => (int) $this->rating,
            "created_at" => $this->created_at
        ];
    }
}

<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "data" => $this->data,
            // "is_read" => $this->notifiable->isRead($this->id),
            "is_read" => (bool) $this->read_at,
            "read_at" => $this->read_at
        ];
    }
}

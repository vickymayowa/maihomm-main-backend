<?php

namespace App\Http\Resources\Properties;

use App\Constants\PropertyConstants;
use App\Http\Resources\FileResource;
use App\Services\Property\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyFilesResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "url" => $this->file->url()
        ];
    }
}

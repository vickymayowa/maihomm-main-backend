<?php

namespace App\Http\Resources\Properties;

use App\Constants\PropertyConstants;
use App\Services\Property\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertieskResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        ];
    }
}

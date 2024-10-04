<?php

namespace App\Services\Property;

use App\Models\PropertySpecification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PropertySpecificationService
{
    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "property_id" => "nullable|exists:properties,id",
            "title" => "required|string",
            "key" => "nullable|string",
            "value" => "r   equired|string",
            "price" => "nullable|numeric",
            "is_default" => "nullable|numeric",
            "group" => "nullable|string",
            "metadata" => "nullable|string",
            "icon" => "nullable|string",
            "status" => "nullable|string",

        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public static function save(array $data, $id = null)
    {
        $data = self::validate($data, $id);
        if (empty($data["key"] ?? null)) {
            $data["key"] = $data["title"] ?? null;
        }

        if (empty($data["metadata"] ?? null)) {
            $data["metadata"] = json_encode([
                "icon" => $data["icon"] ?? null
            ]);
        }

        if (!empty($data["icon"] ?? null)) {
            unset($data["icon"]);
        }

        if (!empty($id)) {
            $property_specification = PropertySpecification::find($id);
            $property_specification->update($data);
        } else {
            $property_specification = PropertySpecification::create($data);
        }

        return $property_specification;
    }
}

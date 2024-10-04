<?php

namespace App\Services\Property;

use App\Models\PropertyFile;

class PropertyImageService
{

    public static function create($property, $file_id, $type)
    {
        $files_count = PropertyFile::where("property_id", $property->id)->orderBy("id")->count();
        return PropertyFile::updateOrCreate([
            "property_id" => $property->id,
            "file_id" => $file_id,
            "type" => $type,
            "is_default" => 1
        ], [
            "order" => $files_count + 1
        ]);
    }
}

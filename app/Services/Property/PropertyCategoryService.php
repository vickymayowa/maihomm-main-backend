<?php

namespace App\Services\Property;

use App\Constants\Media\FileConstants;
use App\Constants\StatusConstants;
use App\Models\PropertyCategory;
use App\Services\Media\FileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PropertyCategoryService
{

    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "status" => "required|string|" . Rule::in(StatusConstants::ACTIVE_OPTIONS),
            "name" => "required|string|unique:product_categories,name,$id",
            "category_id" => "nullable|exists:product_categories,id",
            "logo" => "image|" . Rule::requiredIf(empty($id)),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function create(array $data): PropertyCategory
    {
        $data = self::validate($data);

        if (!empty($cover = $data["logo"] ?? null)) {
            $fileService = new FileService;
            $saved_file = $fileService
                ->setMoveFile(true)
                ->saveFromFile(
                    $cover,
                    FileConstants::PRODUCT_CATEGORY_IMAGE_PATH,
                    null,
                    auth()->id()
                );
            $data["logo_id"] = $saved_file->id;
        }
        unset($data["logo"]);
        $data["uuid"] = self::generateUuid();


        return PropertyCategory::create($data);;
    }

    public static function update(array $data, $id): PropertyCategory
    {
        $data = self::validate($data, $id);
        $category = PropertyCategory::find($id);

        if (!empty($cover = $data["logo"] ?? null)) {
            $fileService = new FileService;
            $saved_file = $fileService
                ->setMoveFile(true)
                ->saveFromFile(
                    $cover,
                    FileConstants::PRODUCT_CATEGORY_IMAGE_PATH,
                    $category->logo_id,
                    auth()->id()
                );
            $data["logo_id"] = $saved_file->id;
        }
        unset($data["logo"]);

        $category->update($data);

        return $category->refresh();
    }


    public static function generateUuid()
    {
        $key = getRandomToken(6);
        $check = PropertyCategory::where("uuid", $key)->count();
        if ($check > 0) {
            return self::generateUuid();
        }
        return $key;
    }

    public static function delete($id)
    {

    }
}

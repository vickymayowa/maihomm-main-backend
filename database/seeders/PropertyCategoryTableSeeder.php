<?php

namespace Database\Seeders;

use App\Helpers\MediaHandler;
use App\Models\PropertyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class PropertyCategoryTableSeeder extends Seeder
{
    public $mediaHandler;
    public function __construct(MediaHandler $mediaHandler)
    {
        $this->mediaHandler = $mediaHandler;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["Residential", "Commercial", "Industrial", "Raw land", "special"];
        foreach ($categories as $category) {
            $check = PropertyCategory::where(['name' => $category])->count();

            if($check > 0){
                continue;
            }
            
            $form_file = new UploadedFile(public_path("samples/laravel.png"), "laravel.png");

            if (!empty($form_file)) {
                $coverImageFile = $this->saveCoverImage($form_file, null);
            }

            PropertyCategory::firstOrCreate(
                ['name' => $category],
                [
                    'name' => $category,
                    'uuid' => slugify($category),
                    "status" => "Active",
                    "logo_id" => $coverImageFile->id ?? 1
                ]
            );
        }
    }



    public function saveCoverImage($cover_image, $cover_image_id = null)
    {
        $filePath = putFileInPrivateStorage($cover_image, "temp");
        return $this->mediaHandler->saveFromFilePath(storage_path("app/$filePath"), "property_categories", $cover_image_id);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyFile;
use App\Services\Media\FileService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class PropertyFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::get();
        foreach ($properties as $key => $property) {
            $this->removeOldFiles($property);
            $allIndexedArray = ["single-property-sm-1.jpg", "sample-video.mp4", "test-sheet.xlsx", "test-word.docx", "single-property-sm-5.jpg", "test-pdf.pdf"];
            // $allIndexedArray = ["test-pdf.pdf"];

            foreach ($allIndexedArray as $key => $indexedArray) {
                $img = $indexedArray;

                $form_file = new UploadedFile(public_path("samples/properties/$img"), "$img");

                if (!empty($logo = $form_file ?? null)) {
                    $fileService = new FileService;
                    $savedFile = $fileService->saveFromFile($logo, "property_image", null, null);
                    $data["file_id"] = $savedFile->id;
                    $data["type"] = $this->getFileType(storage_path($savedFile->path));
                }

                $property_file = PropertyFile::create([
                    "property_id" => $property->id,
                    "file_id" => $data["file_id"],
                    "type" => $data["type"],
                    "is_default" => 1
                ]);

                if ($property_file->is_default == 1) {
                    PropertyFile::whereNotIn("id", [$property_file->id])
                        ->where("property_id", $property_file->property_id)
                        ->where("type", $data["type"])
                        ->update([
                            "is_default" => 0
                        ]);
                }
            }
        }
    }

    // function getType($file): string
    // {
    //     $mime_type = mime_content_type($file);
    //     return strtok($mime_type, '/');
    // }

    public function getFileType($file)
    {
        $type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
        finfo_close(finfo_open(FILEINFO_MIME_TYPE));

        if (in_array($type, ["image/jpeg", "video/x-matroska"])) {
            $type = strtok($type, '/');
        } elseif ($type == "application/pdf") {
            $type = explode("/", $type)[1];
        } else {
            $val = implode(".", array_slice(explode(".", $type), -2));
            if ($val == "spreadsheetml.sheet") {
                $type = "sheet_document";
            } else if ($val == "wordprocessingml.document") {
                $type = "word_document";
            }
        }
        return $type;
    }

    public function removeOldFiles($property)
    {
        optional($property->files())->delete();
        foreach ($property->files ?? [] as $key => $property_file) {
            FileService::cleanDelete($property_file->file_id);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Imports\PropertyImport;
use App\Models\Property;
use App\Models\PropertyFile;
use App\Services\Media\FileService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class PropertyExcelFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $form_file = new UploadedFile(public_path("samples/properties/properties-excel.xlsx"), "properties-excel.xlsx");

            Excel::import(new PropertyImport(), $form_file->store('App/Public', ['disk' => 'public']));
        } catch (\Exception $e) {
            // Handle the exception here
        }
    }
}

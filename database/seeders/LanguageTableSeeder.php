<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = ["English (US)", "Spanish", "French", "German"];

        foreach($languages as $lang){
            Language::create(["name" => $lang]);
        }
    }
}

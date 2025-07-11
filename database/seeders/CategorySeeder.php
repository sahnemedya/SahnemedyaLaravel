<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate(
            ['id' => 1], // eşleşme kriteri
            [
                "name" => "Tıbbi Birimler",
                "show_panel" => 1,
                "lang_id" => 1,
                "is_medical_unit" => 1,
                "is_doctors" => 0
            ]
        );

        Category::updateOrCreate(
            ['id' => 2], // eşleşme kriteri
            [
                "name" => "Doktorlarımız",
                "show_panel" => 1,
                "lang_id" => 1,
                "is_medical_unit" => 0,
                "is_doctors" => 1
            ]
        );
    }
}

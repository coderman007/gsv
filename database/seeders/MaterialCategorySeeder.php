<?php

namespace Database\Seeders;

use App\Models\MaterialCategory;
use Illuminate\Database\Seeder;

class MaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable model events during the seeding process
        MaterialCategory::withoutEvents(function () {
            // Define sample material categories data
            $categoriesData =
                [
                ['name' => 'Estructura'],
                ['name' => 'Paneles'],
                ['name' => 'Inversores'],
                ['name' => 'Material Eléctrico'],
            ];

            // Insert data into the material_categories table
            MaterialCategory::insert($categoriesData);
        });
    }
}

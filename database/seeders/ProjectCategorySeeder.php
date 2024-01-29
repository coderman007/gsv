<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable model events during the seeding process
        ProjectCategory::withoutEvents(function () {
            // Define sample project categories data
            $categoriesData = [
                [
                    'name' => 'APU Sistema Fotovoltaico',
                    'description' => 'Descripción de Sistema Fotovolta',
                    'status' => 'Activo',
                ],
                [
                    'name' => 'APU Sistema Eólico',
                    'description' => 'Descripción de Sistema Eólico',
                    'status' => 'Inactivo',
                ],
                [
                    'name' => 'Categoría 3',
                    'description' => 'Descripción de Categoría 3',
                    'status' => 'Activo',
                ],
            ];

            // Insert data into the project_categories table
            ProjectCategory::insert($categoriesData);
        });
    }
}


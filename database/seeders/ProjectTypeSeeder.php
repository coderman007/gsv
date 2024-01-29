<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectType;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable model events during the seeding process
        ProjectType::withoutEvents(function () {
            // Define sample project types data
            $typesData = [
                [
                    'name' => 'On-Grid',
                    'description' => 'Descripción para sistemas On-Grid',
                    'status' => 'Activo',
                ],
                [
                    'name' => 'Off-Grid',
                    'description' => 'Descripción para sistemas Off-Grid',
                    'status' => 'Inactivo',
                ],
                [
                    'name' => 'Tipo 3',
                    'description' => 'Descripción para el Tipo 3',
                    'status' => 'Activo',
                ],
            ];

            // Insert data into the project_types table
            ProjectType::insert($typesData);
        });
    }
}

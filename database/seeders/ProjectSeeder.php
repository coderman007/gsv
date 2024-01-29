<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable model events during the seeding process
        Project::withoutEvents(function () {
            // Define sample projects data
            $projectsData = [
                [
                    'project_category_id' => 1, 
                    'project_type_id' => 1, 
                    'name' => 'Sistema Fotovoltaico On-Grid',
                    'description' => 'Descripción Sistema Fotovoltaico On-Grid',
                    'status' => 'Activo',
                ],

                [
                    'project_category_id' => 1, 
                    'project_type_id' => 2,
                    'name' => 'Sistema Fotovoltaico Off-Grid',
                    'description' => 'Descripción Sistema Fotovoltaico Off-Grid',
                    'status' => 'Activo',
                ],

                [
                    'project_category_id' => 2,
                    'project_type_id' => 2,     
                    'name' => 'Proyecto 2',
                    'description' => 'Descripción para Proyecto 2',
                    'status' => 'Inactivo',
                ],

                [
                    'project_category_id' => 3,
                    'project_type_id' => 3,     
                    'name' => 'Proyecto 3',
                    'description' => 'Descripción para Proyecto 3',
                    'status' => 'Activo',
                ],
            ];

            // Insert data into the projects table
            Project::insert($projectsData);
        });
    }
}

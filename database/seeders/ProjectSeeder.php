<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projectData = [
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 1.5 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 1.5 KWP',
                'kilowatts_to_provide' => 1.5,
                'zone' => 'Norte Antioqueño - Granja',
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 2,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 4.4 KWP OFF-GRID 1600AH CAPACIDAD ALMACENAMIENTO',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo Off-Grid, que proporciona 4.4 KWP',
                'kilowatts_to_provide' => 4.4,
                'zone' => null,
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 3.0 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 3.0 KWP',
                'kilowatts_to_provide' => 3.0,
                'zone' => 'ZONA_DEL_TERCER_PROYECTO',
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 2,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 2.2 KWP OFF-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo Off-Grid, que proporciona 2.2 KWP',
                'kilowatts_to_provide' => 2.2,
                'zone' => 'ZONA_DEL_CUARTO_PROYECTO',
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 5.5 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 5.5 KWP',
                'kilowatts_to_provide' => 5.5,
                'zone' => null,
                'status' => 'Activo',
            ],
        ];

        // Insertar los datos en la base de datos
        DB::table('projects')->insert($projectData);

        // Obtener los proyectos después de insertarlos
        $projects = Project::all();

        foreach ($projects as $project) {
            // Obtener las posiciones por nombre
            $coordinator = Position::where('name', 'Coordinador de Servicios')->first();
            $officialB = Position::where('name', 'Oficial A')->first(); // Ajustar el nombre a 'Oficial A'

            // Asociar las posiciones al proyecto con el número de días requeridos
            if ($coordinator) {
                $project->positions()->attach($coordinator->id, ['required_days' => 3]); // Ajustar según tus necesidades
            }

            if ($officialB) {
                $project->positions()->attach($officialB->id, ['required_days' => 3]); // Ajustar según tus necesidades
            }
        }
    }
}

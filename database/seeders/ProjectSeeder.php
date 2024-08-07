<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Position;
use App\Models\Project;
use App\Models\Tool;
use App\Models\Transport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projectData = [
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 1.5 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 1.5 KWP',
                'power_output' => 1.5,
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 2,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 4.4 KWP OFF-GRID 1600AH CAPACIDAD ALMACENAMIENTO',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo Off-Grid, que proporciona 4.4 KWP',
                'power_output' => 4.4,
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 3.0 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 3.0 KWP',
                'power_output' => 3.0,
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 2,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 2.2 KWP OFF-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo Off-Grid, que proporciona 2.2 KWP',
                'power_output' => 2.2,
                'status' => 'Activo',
            ],
            [
                'project_category_id' => 1,
                'name' => 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 5.5 KWP ON-GRID',
                'description' => 'Sistema de Generación Solar Fotovoltaico Tipo On-Grid, que proporciona 5.5 KWP',
                'power_output' => 5.5,
                'status' => 'Activo',
            ],
        ];

        // Insertar los datos en la base de datos
        DB::table('projects')->insert($projectData);

        $project = Project::where('name', 'SISTEMA DE GENERACIÓN SOLAR FOTOVOLTAICO 1.5 KWP ON-GRID')->first();

        if ($project) {
            // Obtener las posiciones por nombre
            $engineerA = Position::where('name', 'Ingeniero A')->first();
            $engineerB = Position::where('name', 'Ingeniero B')->first();
            $electrician = Position::where('name', 'Oficial Electricista')->first();

            // Asociar las posiciones al proyecto con el número de días requeridos
            if ($engineerB) {
                $quantity = 2;
                $requiredDays = 1.5;
                $salaryPerDay = $engineerB->real_daily_cost; // Cada posición tiene un salario básico diario
                $totalCost = $requiredDays * $salaryPerDay * $quantity;

                $project->positions()->attach($engineerB->id, [
                    'quantity' => $quantity,
                    'required_days' => $requiredDays,
                    'total_cost' => $totalCost,
                ]);
            }

            if ($engineerA) {
                $quantityEngineerA = 1;
                $requiredDaysEngineerA = 2;
                $salaryPerDayEngineerA = $engineerA->real_daily_cost;
                $totalCostEngineerA = $requiredDaysEngineerA * $salaryPerDayEngineerA * $quantityEngineerA;

                $project->positions()->attach($engineerA->id, [
                    'quantity' => $quantityEngineerA,
                    'required_days' => $requiredDaysEngineerA,
                    'total_cost' => $totalCostEngineerA,
                ]);
            }

            if ($electrician) {
                $quantityElectrician = 3;
                $requiredDaysElectrician = 3;
                $salaryPerDayElectrician = $electrician->real_daily_cost;
                $totalCostElectrician = $requiredDaysElectrician * $salaryPerDayElectrician * $quantityElectrician;

                $project->positions()->attach($electrician->id, [
                    'quantity' => $quantityElectrician,
                    'required_days' => $requiredDaysElectrician,
                    'total_cost' => $totalCostElectrician,
                ]);
            }

            // Asociar materiales al proyecto con la cantidad necesaria
            $material1 = Material::where('reference', 'varilla roscada zincada de 3/8 x 3 mts')->first();
            $material2 = Material::where('reference', 'estacón de polipropileno 5x300 cms')->first();
            $material3 = Material::where('reference', 'varilla cooper weld 2.40 mts con grapa')->first();

            if ($material1) {
                $quantity = 100; // Supongamos que se requieren 100 unidades de este material
                $unitPrice = $material1->unit_price; // Supongamos que cada material tiene un precio unitario
                $totalCost = $quantity * $unitPrice;

                $project->materials()->attach($material1->id, [
                    'quantity' => $quantity,
                    'total_cost' => $totalCost,
                ]);
            }

            if ($material2) {
                $quantityMaterial2 = 50; // Definimos la cantidad necesaria para este material
                $totalCostMaterial2 = $quantityMaterial2 * $material2->unit_price; // Calculamos el costo total

                // Adjuntamos la información al proyecto
                $project->materials()->attach($material2->id, [
                    'quantity' => $quantityMaterial2,
                    'total_cost' => $totalCostMaterial2,
                ]);
            }

            if ($material3) {
                $quantityMaterial3 = 200; // Establecemos la cantidad necesaria
                $totalCostMaterial3 = $quantityMaterial3 * $material3->unit_price; // Calculamos el costo total

                // Adjuntamos la información al proyecto
                $project->materials()->attach($material3->id, [
                    'quantity' => $quantityMaterial3,
                    'total_cost' => $totalCostMaterial3,
                ]);
            }

            // Obtener las herramientas generales
            $generalTools = Tool::whereIn('name', ['Taladro eléctrico', 'Juego de llaves combinadas', 'Multímetro digital'])->get();

            // Asociar las herramientas generales al proyecto
            foreach ($generalTools as $tool) {
                // Calcular el costo total de la herramienta general
                $totalCostPercentage = 0.05;
                $totalLaborCost = $project->positions->sum('pivot.total_cost');
                $totalCost = $totalLaborCost * $totalCostPercentage;

                // Asociar la herramienta al proyecto con la cantidad, días requeridos y costo total
                $project->tools()->attach($tool->id, [
                    'quantity' => 1, // Puedes ajustar la cantidad según tus necesidades
                    'required_days' => 1, // Puedes ajustar los días requeridos según tus necesidades
                    'total_cost' => $totalCost,
                ]);
            }

            // Asociar herramientas específicas al proyecto
            $specificToolDetails = [
                'name' => 'Herramienta Especializada 1',
                'unit_price_per_day' => 150.00,
            ];

            // Guardar la herramienta específica en la base de datos
            $specificTool = Tool::create($specificToolDetails);

            // Asociar la herramienta específica al proyecto con los detalles dinámicos en la tabla pivote
            $project->tools()->attach($specificTool->id, [
                'quantity' => 2,
                'required_days' => 3,
                'total_cost' => 0,
            ]);

            // Asociar el transporte al proyecto
            $transport = Transport::where('vehicle_type', 'Carro')->first(); // Puedes ajustar esto según tus necesidades

            if ($transport) {
                // Puedes ajustar la cantidad y los días según tus necesidades
                $quantity = 1;
                $requiredDays = 2;

                // Calcula el costo total en función de los días y la cantidad
                $costPerDay = $transport->salary_per_hour * 8; // Costo diario basado en el salario por hora
                $costPerKm = $transport->cost_per_km_conventional; // Puedes cambiar a cost_per_km_fuel según tus necesidades
                $totalCost = ($costPerDay * $requiredDays * $quantity) + ($costPerKm * $transport->annual_mileage / 1000 * $quantity);

                // Asocia el transporte al proyecto con los detalles dinámicos en la tabla pivote
                $project->transports()->attach($transport->id, [
                    'quantity' => $quantity,
                    'required_days' => $requiredDays,
                    'total_cost' => $totalCost,
                ]);
            }
        }
    }
}

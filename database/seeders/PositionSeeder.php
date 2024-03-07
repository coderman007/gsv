<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $positionsData = [
            [
                'name' => 'Coordinador de Servicios',
                'basic' => 3350000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Coordinador de Proyectos',
                'basic' => 4000000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Ingeniero A',
                'basic' => 2500000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Ingeniero B',
                'basic' => 2750000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Ingeniero C',
                'basic' => 3000000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Practicante de ingenieria',
                'basic' => 1160000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Auxiliar de Ingenieria',
                'basic' => 2000000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Oficial Lider',
                'basic' => 1850000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Oficial Electricista',
                'basic' => 1500000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Auxiliar Electricista',
                'basic' => 1320000,
                'working_hours' => 8,
                'monthly_work_hours' => 173,
                'benefit_factor' => 1.54,
            ],

        ];

        foreach ($positionsData as &$positionData) {
            // Calcula el sueldo diario 
            $positionData['real_daily_cost'] = $positionData['basic'] * $positionData['benefit_factor'] * $positionData['working_hours'] / $positionData['monthly_work_hours'];

            // Calcula el costo mensual real 
            $positionData['real_monthly_cost'] = $positionData['real_daily_cost'] / $positionData['working_hours'] * $positionData['monthly_work_hours'];

            // Crea el registro en la base de datos
            Position::create($positionData);
        }
    }
}
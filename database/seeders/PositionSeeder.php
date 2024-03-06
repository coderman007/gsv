<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $positionsData =
            [
            [
                'name' => 'Coordinador de Servicios',
                'basic' => 3350000,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Coordinador de Proyectos',
                'basic' => 4000000,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Ingeniero A',
                'basic' => 1500000,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Ingeniero B',
                'basic' => 1400000,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Oficial A',
                'basic' => 1100000,
                'benefit_factor' => 1.54,
            ],
            [
                'name' => 'Auxiliar B',
                'basic' => 850000,
                'benefit_factor' => 1.54,
            ],
        ];

        foreach ($positionsData as $positionData) {
            Position::create($positionData);
        }
    }
}
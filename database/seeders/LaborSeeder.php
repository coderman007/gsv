<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Labor;

class LaborSeeder extends Seeder
{
    public function run()
    {
        $laborsData = [
            [
                'position' => 'Coordinador de Servicios',
                'basic' => 3350000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 5159000,
                'real_daily_cost' => 229289,
            ],
            [
                'position' => 'Coordinador de Proyectos',
                'basic' => 4000000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 6160000,
                'real_daily_cost' => 273778,
            ],
            [
                'position' => 'Ingeniero A',
                'basic' => 2500000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 3850000,
                'real_daily_cost' => 171111,
            ],
            [
                'position' => 'Ingeniero B',
                'basic' => 2750000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 4235000,
                'real_daily_cost' => 188222,
            ],
            [
                'position' => 'Ingeniero C',
                'basic' => 3000000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 4620000,
                'real_daily_cost' => 205333,
            ],
            [
                'position' => 'Practicante de ingenieria',
                'basic' => 1160000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 1786400,
                'real_daily_cost' => 79396,
            ],
            [
                'position' => 'Auxiliar de Ingenieria',
                'basic' => 2000000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 3080000,
                'real_daily_cost' => 136889,
            ],
            [
                'position' => 'Oficial Lider',
                'basic' => 1850000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 2849000,
                'real_daily_cost' => 126622,
            ],
            [
                'position' => 'Oficial Electricista',
                'basic' => 1500000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 2310000,
                'real_daily_cost' => 102667,
            ],
            [
                'position' => 'Auxiliar Electricista',
                'basic' => 1320000,
                'benefit_factor' => 1.54,
                'real_monthly_cost' => 2032800,
                'real_daily_cost' => 90347,
            ],
            // Agrega el resto de los registros de acuerdo a la estructura
        ];

        foreach ($laborsData as $laborData) {
            Labor::create($laborData);
        }
    }
}

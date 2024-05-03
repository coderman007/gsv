<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    public function run(): void
    {
        $transportsData = [
            [
                'vehicle_type' => 'camión',
                'gasoline_cost_per_km' => 525.00,
                'toll_cost' => 9701.00,
                'cost_per_day' => 330000.00,
            ],
            [
                'vehicle_type' => 'automóvil',
                'gasoline_cost_per_km' => 425.00,
                'toll_cost' => 6701.00,
                'cost_per_day' => 250000.00,
            ],
            [
                'vehicle_type' => 'motocicleta',
                'gasoline_cost_per_km' => 225.00,
                'cost_per_day' => 130000.00,

            ],
        ];

        foreach ($transportsData as $transportData) {
            (new Transport)->create($transportData);
        }
    }
}

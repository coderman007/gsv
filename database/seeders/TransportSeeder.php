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
                'vehicle_type' => 'Camión',
                'capacity' => 10,
                'fuel_type' => 'Diesel',
                'cost_per_day' => 330000.00,
            ],
            [
                'vehicle_type' => 'Automóvil',
                'capacity' => 5,
                'fuel_type' => 'Gasolina',
                'cost_per_day' => 250000.00,
            ],
            [
                'vehicle_type' => 'Motocicleta',
                'capacity' => 2,
                'fuel_type' => 'Gasolina',
                'cost_per_day' => 130000.00,

            ],
        ];

        foreach ($transportsData as $transportData) {
            (new Transport)->create($transportData);
        }
    }
}

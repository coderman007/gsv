<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    public function run()
    {
        $transportsData = [
            [
                'vehicle_type' => 'Carro',
                'annual_mileage' => 20000,
                'average_speed' => 60.00,
                'commercial_value' => 45000000.00,
                'depreciation_rate' => 8.00,
                'annual_maintenance_cost' => 11832200.00,
                'cost_per_km_conventional' => 592.00,
                'cost_per_km_fuel' => 325.00,
                'salary_per_month' => 1300000.00,
                'salary_per_hour' => 6701.00,
            ],
            [
                'vehicle_type' => 'Moto',
                'annual_mileage' => 15000,
                'average_speed' => 60.00,
                'commercial_value' => 8000000.00,
                'depreciation_rate' => 8.00,
                'annual_maintenance_cost' => 3970000.00,
                'cost_per_km_conventional' => 265.00,
                'cost_per_km_fuel' => 140.00,
                'salary_per_month' => 1160000.00,
                'salary_per_hour' => 5979.00,
            ],
        ];

        foreach ($transportsData as $transportData) {
            Transport::insert($transportData);
        }
    }
}

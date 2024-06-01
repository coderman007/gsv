<?php

namespace Database\Seeders;

use App\Models\Additional;
use Illuminate\Database\Seeder;

class AdditionalSeeder extends Seeder
{
    public function run(): void
    {
        $additionalsData = [
            [
                'name' => 'Diesel',
                'description' => 'Diesel',
                'unit_price' => 330000.00,
            ],
            [
                'name' => 'Peaje',
                'description' => 'Peaje',
                'unit_price' => 250000.00,
            ],
            [
                'name' => 'Gasolina',
                'description' => 'Gasolina',
                'unit_price' => 130000.00,

            ],
        ];

        foreach ($additionalsData as $additionalData) {
            (new Additional)->create($additionalData);
        }
    }
}

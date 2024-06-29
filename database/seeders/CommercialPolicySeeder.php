<?php

namespace Database\Seeders;

use App\Models\CommercialPolicy;
use Illuminate\Database\Seeder;

class CommercialPolicySeeder extends Seeder
{
    public function run(): void
    {
        $commercialPoliciesData = [
            [
                'name' => 'Comisiones Internas',
                'percentage' =>3,
            ],
            [
                'name' => 'Comisiones Externas',
                'percentage' => 3,
            ],
            [
                'name' => 'Margen',
                'percentage' => 25,
            ],
            [
                'name' => 'Descuento',
                'percentage' => 5,
            ],
        ];

        foreach ($commercialPoliciesData as $commercialPolicyData) {
            (new CommercialPolicy)->create($commercialPolicyData);
        }
    }
}

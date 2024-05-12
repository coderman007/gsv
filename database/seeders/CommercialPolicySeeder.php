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
                'name' => 'internal_commissions',
                'percentage' =>3,
            ],
            [
                'name' => 'external_commissions',
                'percentage' => 3,
            ],
            [
                'name' => 'margin',
                'percentage' => 25,
            ],
            [
                'name' => 'discount',
                'percentage' => 5,
            ],
        ];

        foreach ($commercialPoliciesData as $commercialPolicyData) {
            (new CommercialPolicy)->create($commercialPolicyData);
        }
    }
}

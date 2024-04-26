<?php

namespace Database\Factories;

use App\Models\AdditionalCost;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdditionalCostFactory extends Factory
{
    protected $model = AdditionalCost::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'amount' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'quotation_id' => Quotation::factory(),
        ];
    }
}

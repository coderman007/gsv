<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransportFactory extends Factory
{
    protected $model = Transport::class;

    public function definition(): array
    {
        return [
            'vehicle_type' => $this->faker->word(),
            'annual_mileage' => $this->faker->randomNumber(),
            'average_speed' => $this->faker->randomFloat(),
            'commercial_value' => $this->faker->randomFloat(),
            'depreciation_rate' => $this->faker->randomFloat(),
            'annual_maintenance_cost' => $this->faker->randomFloat(),
            'cost_per_km_conventional' => $this->faker->randomFloat(),
            'cost_per_km_fuel' => $this->faker->randomFloat(),
            'salary_per_month' => $this->faker->randomFloat(),
            'salary_per_hour' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

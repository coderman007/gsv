<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/Locations/cities.json'), true);

        foreach ($data['data'] as $city) {
            City::create([
                'id' => $city['id'],
                'department_id' => $city['department_id'],
                'name' => $city['name'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/Locations/countries.json'), true);

        foreach ($data['data'] as $country) {
            Country::create([
                'id' => $country['id'],
                'name' => $country['name'],
            ]);
        }
    }
}

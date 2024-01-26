<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        // Verificar si ya existe Colombia en la base de datos
        $colombia = Country::where('name', 'Colombia')->first();

        if (!$colombia) {
            Country::create(['name' => 'Colombia']);
            $this->command->info('"Colombia" agregado.');
        } else {
            $this->command->info('"Colombia" ya existe en la base de datos.');
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            'Colombia',
            'Argentina',
            'Mexico',
            'Spain',
            'Brazil',
            'Chile'
            // Agrega los otros países que desees aquí
        ];

        foreach ($countries as $countryName) {
            // Verificar si ya existe el país en la base de datos
            $country = Country::where('name', $countryName)->first();

            if (!$country) {
                Country::create(['name' => $countryName]);
                $this->command->info('"' . $countryName . '" agregado.');
            } else {
                $this->command->info('"' . $countryName . '" ya existe en la base de datos.');
            }
        }
    }
}

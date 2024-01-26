<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Jaime',
            'email' => 'coderman1980@gmail.com',
            'password' => bcrypt('coderman'),
            'status' => 'Activo',
        ]);

        $this->call([
            CountrySeeder::class,
            DepartmentSeeder::class,
            CitySeeder::class,
        ]);
    }
}

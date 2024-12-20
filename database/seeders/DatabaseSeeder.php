<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MacroEconomicVariable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CountrySeeder::class,
            DepartmentSeeder::class,
            CitySeeder::class,
            ProjectCategorySeeder::class,
            MaterialCategorySeeder::class,
            PositionSeeder::class,
            MaterialSeeder::class,
//            ToolSeeder::class,
//            TransportSeeder::class,
//            AdditionalSeeder::class,
            CommercialPolicySeeder::class,
            MacroEconomicVariableSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Jaime Sierra',
            'email' => 'coderman1980@gmail.com',
            'password' => bcrypt('coderman'),
            'status' => 'Activo',
        ]);

        $user->assignRole('Administrador');
    }
}

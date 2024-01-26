<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Iniciamos una transacción
        DB::beginTransaction();

        try {
            // Obtén el país al que asociarás los departamentos (en este caso, Colombia)
            $colombia = Country::where('name', 'Colombia')->first();

            // Array para almacenar los datos de los departamentos
            $departmentsData = [
                ['name' => 'Amazonas'],
                ['name' => 'Antioquia'],
                ['name' => 'Arauca'],
                ['name' => 'Atlántico'],
                ['name' => 'Bolívar'],
                ['name' => 'Boyacá'],
                ['name' => 'Caldas'],
                ['name' => 'Caquetá'],
                ['name' => 'Casanare'],
                ['name' => 'Cauca'],
                ['name' => 'Cesar'],
                ['name' => 'Chocó'],
                ['name' => 'Córdoba'],
                ['name' => 'Cundinamarca'],
                ['name' => 'Guainía'],
                ['name' => 'Guaviare'],
                ['name' => 'Huila'],
                ['name' => 'La Guajira'],
                ['name' => 'Magdalena'],
                ['name' => 'Meta'],
                ['name' => 'Nariño'],
                ['name' => 'Norte de Santander'],
                ['name' => 'Putumayo'],
                ['name' => 'Quindío'],
                ['name' => 'Risaralda'],
                ['name' => 'San Andrés y Providencia'],
                ['name' => 'Santander'],
                ['name' => 'Sucre'],
                ['name' => 'Tolima'],
                ['name' => 'Valle del Cauca'],
                ['name' => 'Vaupés'],
                ['name' => 'Vichada'],
            ];

            // Insertar los departamentos asociados al país
            foreach ($departmentsData as &$department) {
                $department['country_id'] = $colombia->id;
            }

            Department::insert($departmentsData);

            // Confirmar la transacción
            DB::commit();
        } catch (\Exception $e) {
            // Revertir la transacción si ocurre un error
            DB::rollback();
            throw new \Exception("Error durante la inserción de departamentos: {$e->getMessage()}");
        }
    }
}

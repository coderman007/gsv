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
            // Array para almacenar los datos de los departamentos
            $departmentsData = [
                // Colombia
                ['name' => 'Amazonas', 'country_name' => 'Colombia'],
                ['name' => 'Antioquia', 'country_name' => 'Colombia'],
                ['name' => 'Arauca', 'country_name' => 'Colombia'],
                ['name' => 'Atlántico', 'country_name' => 'Colombia'],
                ['name' => 'Bolívar', 'country_name' => 'Colombia'],
                ['name' => 'Boyacá', 'country_name' => 'Colombia'],
                ['name' => 'Caldas', 'country_name' => 'Colombia'],
                ['name' => 'Caquetá', 'country_name' => 'Colombia'],
                ['name' => 'Casanare', 'country_name' => 'Colombia'],
                ['name' => 'Cauca', 'country_name' => 'Colombia'],
                ['name' => 'Cesar', 'country_name' => 'Colombia'],
                ['name' => 'Chocó', 'country_name' => 'Colombia'],
                ['name' => 'Córdoba', 'country_name' => 'Colombia'],
                ['name' => 'Cundinamarca', 'country_name' => 'Colombia'],
                ['name' => 'Guainía', 'country_name' => 'Colombia'],
                ['name' => 'Guaviare', 'country_name' => 'Colombia'],
                ['name' => 'Huila', 'country_name' => 'Colombia'],
                ['name' => 'La Guajira', 'country_name' => 'Colombia'],
                ['name' => 'Magdalena', 'country_name' => 'Colombia'],
                ['name' => 'Meta', 'country_name' => 'Colombia'],
                ['name' => 'Nariño', 'country_name' => 'Colombia'],
                ['name' => 'Norte de Santander', 'country_name' => 'Colombia'],
                ['name' => 'Putumayo', 'country_name' => 'Colombia'],
                ['name' => 'Quindío', 'country_name' => 'Colombia'],
                ['name' => 'Risaralda', 'country_name' => 'Colombia'],
                ['name' => 'San Andrés y Providencia', 'country_name' => 'Colombia'],
                ['name' => 'Santander', 'country_name' => 'Colombia'],
                ['name' => 'Sucre', 'country_name' => 'Colombia'],
                ['name' => 'Tolima', 'country_name' => 'Colombia'],
                ['name' => 'Valle del Cauca', 'country_name' => 'Colombia'],
                ['name' => 'Vaupés', 'country_name' => 'Colombia'],
                ['name' => 'Vichada', 'country_name' => 'Colombia'],

                // Argentina
                ['name' => 'Buenos Aires', 'country_name' => 'Argentina'],
                ['name' => 'Córdoba', 'country_name' => 'Argentina'],
                ['name' => 'Mendoza', 'country_name' => 'Argentina'],

                // Mexico
                ['name' => 'Mexico City', 'country_name' => 'Mexico'],
                ['name' => 'Jalisco', 'country_name' => 'Mexico'],
                ['name' => 'Nuevo León', 'country_name' => 'Mexico'],

                // España
                ['name' => 'Madrid', 'country_name' => 'Spain'],
                ['name' => 'Barcelona', 'country_name' => 'Spain'],
                ['name' => 'Valencia', 'country_name' => 'Spain'],

                // Brasil
                ['name' => 'São Paulo', 'country_name' => 'Brazil'],
                ['name' => 'Rio de Janeiro', 'country_name' => 'Brazil'],
                ['name' => 'Bahia', 'country_name' => 'Brazil'],

                // Chile
                ['name' => 'Santiago', 'country_name' => 'Chile'],
                ['name' => 'Valparaíso', 'country_name' => 'Chile'],
                ['name' => 'Biobío', 'country_name' => 'Chile'],
            ];

            foreach ($departmentsData as &$department) {
                // Obtén el país al que asociarás los departamentos
                $country = Country::where('name', $department['country_name'])->first();
                unset($department['country_name']);

                // Asignar el ID del país al departamento
                $department['country_id'] = $country->id;
            }

            // Insertar los departamentos asociados a los países
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

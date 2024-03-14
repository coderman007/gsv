<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/Locations/departments.json'), true);

        foreach ($data['data'] as $department) {
            Department::create([
                'id' => $department['id'],
                'country_id' => $department['country_id'],
                'name' => $department['name'],
            ]);
        }
    }
}

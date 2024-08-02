<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable model events during the seeding process
        ProjectCategory::withoutEvents(function () {
            // Define sample project categories data
            $categoriesData = [
                [
                    'name' => 'Sistema Fotovoltaico On-Grid',
                    'description' => 'El sistema on-grid, también conocido como conectado a la red, es aquel que está conectado a la red eléctrica convencional. Algunas características clave son:
                    Conexión a la Red: Los paneles solares generan electricidad que se inyecta directamente en la red eléctrica de tu área.
                    Compensación de Excedentes: En momentos de alta generación, el exceso de electricidad puede ser enviado de vuelta a la red, obteniendo créditos o compensaciones.
                    Suministro Continuo: Cuando la generación solar es insuficiente, puedes consumir electricidad de la red convencional.',
                    'status' => 'Activo',
                ],

//                [
//                    'name' => 'Sistema Fotovoltaico Off-Grid',
//                    'description' => 'El sistema off-grid es autónomo y no está conectado a la red eléctrica. Características clave:
//                    Independencia Energética: Funciona de manera aislada, ideal para lugares remotos donde la conexión a la red no es viable.
//                    Baterías de Almacenamiento: Almacena la energía generada en baterías para su uso cuando el sol no está disponible.
//                    Generador como Respaldo: En algunos casos, se incorpora un generador diésel o a gas como respaldo en períodos prolongados de baja generación solar.',
//                    'status' => 'Activo',
//                ],
//                [
//                    'name' => 'Sistema de Biomasa',
//                    'description' => 'Este sistema utiliza biomasa, que son materiales orgánicos como residuos agrícolas, madera o residuos forestales, para generar energía. La biomasa se quema, liberando calor que se convierte en electricidad.',
//                    'status' => 'Inactivo',
//                ],
//                [
//                    'name' => 'APU Pequeña Hidroeléctrica',
//                    'description' => 'Este sistema aprovecha la energía del agua para generar electricidad. Una pequeña hidroeléctrica generalmente implica el flujo controlado de agua a través de una turbina para generar energía',
//                    'status' => 'Activo',
//                ],
//
//                [
//                    'name' => 'Sistema Energía Eléctrica Tradicional',
//                    'description' => 'Descripción de Sistema de Energía Eléctrica Tradicional',
//                    'status' => 'Activo',
//                ],
            ];

            // Insert data into the project_categories table
            ProjectCategory::insert($categoriesData);
        });
    }
}

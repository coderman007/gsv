<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    public function run()
    {
        $toolsData = [
            [
                'category' => 'Herramientas Eléctricas',
                'name' => 'Destornillador inalámbrico',
                'unit_price' => 120.00,
            ],
            [
                'category' => 'Herramientas Eléctricas',
                'name' => 'Taladro eléctrico',
                'unit_price' => 200.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Juego de llaves combinadas',
                'unit_price' => 50.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Alicates de corte',
                'unit_price' => 25.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Multímetro digital',
                'unit_price' => 80.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Nivel láser',
                'unit_price' => 150.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Pinza amperimétrica',
                'unit_price' => 100.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Pelacables automático',
                'unit_price' => 30.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Casco de seguridad',
                'unit_price' => 50.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Gafas de protección',
                'unit_price' => 20.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Comprobador de continuidad',
                'unit_price' => 40.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Kit de instalación de paneles solares',
                'unit_price' => 180.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Termómetro infrarrojo',
                'unit_price' => 70.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Luxómetro',
                'unit_price' => 120.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Martillo de electricista',
                'unit_price' => 35.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Destornilladores de precisión',
                'unit_price' => 25.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Arnés de seguridad',
                'unit_price' => 80.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Guantes de trabajo resistentes a impactos',
                'unit_price' => 30.00,
            ],
            [
                'category' => 'Herramientas Eléctricas',
                'name' => 'Sierra circular',
                'unit_price' => 250.00,
            ],
            [
                'category' => 'Herramientas Eléctricas',
                'name' => 'Pistola de calor',
                'unit_price' => 60.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Telémetro láser',
                'unit_price' => 150.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Medidor de ángulos digital',
                'unit_price' => 45.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Kit de herramientas para instalación de inversores',
                'unit_price' => 200.00,
            ],
            [
                'category' => 'Herramientas Especializadas',
                'name' => 'Crimpidora para conectores solares',
                'unit_price' => 90.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Botas de seguridad con puntera de acero',
                'unit_price' => 70.00,
            ],
            [
                'category' => 'Herramientas de Seguridad',
                'name' => 'Protector auricular con cancelación de ruido',
                'unit_price' => 40.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Llave ajustable',
                'unit_price' => 20.00,
            ],
            [
                'category' => 'Herramientas Manuales',
                'name' => 'Juego de destornilladores de precisión',
                'unit_price' => 30.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Medidor de resistencia de tierra',
                'unit_price' => 120.00,
            ],
            [
                'category' => 'Herramientas de Medición',
                'name' => 'Higrómetro digital',
                'unit_price' => 55.00,
            ],

        ];

        foreach ($toolsData as $toolData) {
            Tool::insert($toolsData);
        }
    }
}

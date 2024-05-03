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
                'name' => 'Destornillador inalámbrico',
                'unit_price_per_day' => 120.00,
            ],
            [
                'name' => 'Taladro eléctrico',
                'unit_price_per_day' => 200.00,
            ],
            [
                'name' => 'Juego de llaves combinadas',
                'unit_price_per_day' => 50.00,
            ],
            [
                'name' => 'Alicates de corte',
                'unit_price_per_day' => 25.00,
            ],
            [
                'name' => 'Multímetro digital',
                'unit_price_per_day' => 80.00,
            ],
            [
                'name' => 'Nivel láser',
                'unit_price_per_day' => 150.00,
            ],
            [
                'name' => 'Pinza amperimétrica',
                'unit_price_per_day' => 100.00,
            ],
            [
                'name' => 'Pelacables automático',
                'unit_price_per_day' => 30.00,
            ],
            [
                'name' => 'Casco de seguridad',
                'unit_price_per_day' => 50.00,
            ],
            [
                'name' => 'Gafas de protección',
                'unit_price_per_day' => 20.00,
            ],
            [

                'name' => 'Comprobador de continuidad',
                'unit_price_per_day' => 40.00,
            ],
            [

                'name' => 'Kit de instalación de paneles solares',
                'unit_price_per_day' => 180.00,
            ],
            [
                'name' => 'Termómetro infrarrojo',
                'unit_price_per_day' => 70.00,
            ],
            [
                'name' => 'Luxómetro',
                'unit_price_per_day' => 120.00,
            ],
            [
                'name' => 'Martillo de electricista',
                'unit_price_per_day' => 35.00,
            ],
            [
                'name' => 'Destornilladores de precisión',
                'unit_price_per_day' => 25.00,
            ],
            [
                'name' => 'Arnés de seguridad',
                'unit_price_per_day' => 80.00,
            ],
            [
                'name' => 'Guantes de trabajo resistentes a impactos',
                'unit_price_per_day' => 30.00,
            ],
            [
                'name' => 'Sierra circular',
                'unit_price_per_day' => 250.00,
            ],
            [
                'name' => 'Pistola de calor',
                'unit_price_per_day' => 60.00,
            ],
            [
                'name' => 'Telémetro láser',
                'unit_price_per_day' => 150.00,
            ],
            [
                'name' => 'Medidor de ángulos digital',
                'unit_price_per_day' => 45.00,
            ],
            [
                'name' => 'Kit de  para instalación de inversores',
                'unit_price_per_day' => 200.00,
            ],
            [
                'name' => 'Crimpidora para conectores solares',
                'unit_price_per_day' => 90.00,
            ],
            [
                'name' => 'Botas de seguridad con puntera de acero',
                'unit_price_per_day' => 70.00,
            ],
            [
                'name' => 'Protector auricular con cancelación de ruido',
                'unit_price_per_day' => 40.00,
            ],
            [
                'name' => 'Llave ajustable',
                'unit_price_per_day' => 20.00,
            ],
            [
                'name' => 'Juego de destornilladores de precisión',
                'unit_price_per_day' => 30.00,
            ],
            [
                'name' => 'Medidor de resistencia de tierra',
                'unit_price_per_day' => 120.00,
            ],
            [
                'name' => 'Higrómetro digital',
                'unit_price_per_day' => 55.00,
            ],

        ];

        foreach ($toolsData as $toolData) {
            (new Tool)->create($toolData);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materialsData = [
            [
                'material_category_id' => 1,
                'reference' => 'Módulo Solar',
                'rated_power' => 575,
                'unit_price' => 9838.00,
            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'estacón de polipropileno 5x300 cms',
//                'description' => 'Estacón de polipropileno 5x300 cms',
//                'unit_price' => 53400.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'varilla cooper weld 2.40 mts con grapa',
//                'description' => 'Varilla Cooper Weld 2.40 metros con grapa',
//                'unit_price' => 48600.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'alurack mrail 4.3 mts',
//                'description' => 'Alurack Mrail 4.3 metros',
//                'unit_price' => 130000.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'alurack mclamp',
//                'description' => 'Alurack Mclamp',
//                'unit_price' => 4800.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'alurack eclamp',
//                'description' => 'Alurack Eclamp',
//                'unit_price' => 4800.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'alurack estructura union perfil de 20 centímetros',
//                'description' => 'Alurack estructura unión perfil de 20 centímetros',
//                'unit_price' => 5100.00,
//            ],
//            [
//                'material_category_id' => 1,
//                'reference' => 'alurack estructura L',
//                'description' => 'Alurack estructura L',
//                'unit_price' => 6100.00,
//            ],
//            [
//                'material_category_id' => 2,
//                'reference' => 'panel solar monocristalino 550W',
//                'description' => 'Panel solar monocristalino 550W',
//                'unit_price' => 605000.00,
//            ],
//            [
//                'material_category_id' => 2,
//                'reference' => 'panel solar monocristalino 540W',
//                'description' => 'Panel solar monocristalino 540W',
//                'unit_price' => 648000.00,
//            ],
//
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 2.5 kW monofásico',
//                'description' => 'Inversor Ongird 2.5 kW monofásico',
//                'unit_price' => 2240000.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 3.6 kW monofásico',
//                'description' => 'Inversor Ongird 3.6 kW monofásico',
//                'unit_price' => 2122674.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 5 kW monofásico',
//                'description' => 'Inversor Ongird 5 kW monofásico',
//                'unit_price' => 3300000.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 6 kW monofásico',
//                'description' => 'Inversor Ongird 6 kW monofásico',
//                'unit_price' => 3438296.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 20 kW trifásico 220 VAC',
//                'description' => 'Inversor Ongird 20 kW trifásico 220 VAC',
//                'unit_price' => 10224723.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor ongrid 30 kW trifásico 220VAC',
//                'description' => 'Inversor Ongird 30 kW trifásico 220VAC',
//                'unit_price' => 11963303.00,
//            ],
//            [
//                'material_category_id' => 3,
//                'reference' => 'inversor híbrido off-grid 2000W / 24VDC salida 110AC',
//                'description' => 'Inversor híbrido off-grid 2000W / 24VDC salida 110AC',
//                'unit_price' => 1495600.00,
//            ],
//
//            [
//                'material_category_id' => 4,
//                'reference' => 'caja 12*12*5 datos CT Incamet',
//                'description' => 'Caja 12*12*5 datos CT Incamet',
//                'unit_price' => 6437.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'gabinete plástico 30*30*18',
//                'description' => 'Gabinete plástico 30*30*18',
//                'unit_price' => 151260.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'caja termoplástica Kowet K1111-85 114*114*85mm',
//                'description' => 'Caja termoplástica Kowet K1111-85 114*114*85mm',
//                'unit_price' => 19500.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'caja termoplástica Kowet K1621-135 163*214*135mm',
//                'description' => 'Caja termoplástica Kowet K1621-135 163*214*135mm',
//                'unit_price' => 57200.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'RT - COE - 100 - 100 - 30 Tablero doble fondo',
//                'description' => 'RT - COE - 100 - 100 - 30 Tablero doble fondo',
//                'unit_price' => 810000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'caja de paso 20x20x12 blanca',
//                'description' => 'Caja de paso 20x20x12 blanca',
//                'unit_price' => 29831.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tablero tipo exterior de 122x100x30 cms doble ala',
//                'description' => 'Tablero tipo exterior de 122x100x30 cms doble ala',
//                'unit_price' => 1550000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tablero tipo exterior para medidor',
//                'description' => 'Tablero tipo exterior para medidor',
//                'unit_price' => 450000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'curva pvc 3/4',
//                'description' => 'Curva PVC 3/4',
//                'unit_price' => 515.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tubo pvc 3/4 x3m',
//                'description' => 'Tubo PVC 3/4 x3M',
//                'unit_price' => 5742.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tubo emt 1/2 x 3 mts',
//                'description' => 'Tubo EMT 1/2 x 3 MTS',
//                'unit_price' => 17847.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'coraza liquid t/metal 1 1/2',
//                'description' => 'Coraza Liquid T/Metal 1 1/2',
//                'unit_price' => 10367.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tubo imc 3/4" x 3mts',
//                'description' => 'Tubo IMC 3/4" x 3MTS',
//                'unit_price' => 35800.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tubocb 0215 *00 cuad. 1.1/2 x 1.1/2 crudo',
//                'description' => 'TUBOCB 0215 *00 CUAD. 1.1/2 X 1.1/2 CRUDO',
//                'unit_price' => 45164.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'coraza pvc 1 1/4"',
//                'description' => 'Coraza PVC 1 1/4"',
//                'unit_price' => 9579.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'breaker riel 1x16 amp',
//                'description' => 'Breaker Riel 1X16 Amp',
//                'unit_price' => 25042.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'breaker riel 2x80 amp',
//                'description' => 'Breaker Riel 2X80 Amp',
//                'unit_price' => 58403.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'fusible de loza 10x30 2a-4-6-16-20-25-32 amp',
//                'description' => 'Fusible de Loza 10X30 2A-4-6-16-20-25-32 Amp',
//                'unit_price' => 2436.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'portafusibe riel 1 polo',
//                'description' => 'Portafusible Riel 1 Polo',
//                'unit_price' => 7563.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'med tri iskra mt174 5/120ar lcdcal sll1tu',
//                'description' => 'Medidor Trifásico Iskra MT174 5/120AR LCDCAL SLL1TU',
//                'unit_price' => 441820.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'bkn-b mini interruptor 2p 32 amp icu 10ka',
//                'description' => 'BKN-B Mini Interruptor 2P 32 Amp ICU 10kA',
//                'unit_price' => 28920.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'bkn-b mini interruptor 2p 50 amp icu 10ka',
//                'description' => 'BKN-B Mini Interruptor 2P 50 Amp ICU 10kA',
//                'unit_price' => 31320.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'taco industrial 75 amp l.g',
//                'description' => 'Taco Industrial 75 Amp L.G',
//                'unit_price' => 202184.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'curva emt 1/2',
//                'description' => 'Curva EMT 1/2',
//                'unit_price' => 1000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'union en acero emt 1/2',
//                'description' => 'Unión en Acero EMT 1/2',
//                'unit_price' => 784.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'bornera riel k 16 mm',
//                'description' => 'Bornera Riel K 16 MM',
//                'unit_price' => 7394.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'barraje de cobre 30 cm 150 amp',
//                'description' => 'Barraje de Cobre 30 CM 150 AMP',
//                'unit_price' => 46000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'puente p/bornera vk 16 mm x 2 klemsan',
//                'description' => 'Puente para Bornera VK 16 MM X 2 Klemsan',
//                'unit_price' => 9000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'riel omega perforada',
//                'description' => 'Riel Omega Perforada',
//                'unit_price' => 6302.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'prensacable 29mm pvc',
//                'description' => 'Prensacable 29mm PVC',
//                'unit_price' => 2436.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'niple galv 3/4 x 10 cms',
//                'description' => 'Niple Galvanizado 3/4 x 10 Cms',
//                'unit_price' => 4200.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'niple galv 1 1/2x10 cms',
//                'description' => 'Niple Galvanizado 1 1/2 x 10 Cms',
//                'unit_price' => 10000.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'hex inox 5/16*3',
//                'description' => 'Hexágono de Acero Inoxidable 5/16*3',
//                'unit_price' => 1001.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'wasa inox 5/16',
//                'description' => 'Arandela de Acero Inoxidable 5/16',
//                'unit_price' => 91.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'aran pl inox 5/16',
//                'description' => 'Arandela Plana de Acero Inoxidable 5/16',
//                'unit_price' => 96.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tca inox ro 5/16',
//                'description' => 'Tuerca Ciega de Acero Inoxidable Rosca 5/16',
//                'unit_price' => 185.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'a g1 ro gal 5/16*21/2',
//                'description' => 'Accesorio Galvanizado 5/16*21/2',
//                'unit_price' => 322.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'a g1 ro gal 5/16*3',
//                'description' => 'Accesorio Galvanizado 5/16*3',
//                'unit_price' => 374.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tca a g2 g 5/16',
//                'description' => 'Tuerca Ciega Acoplada a Galvanizado 5/16',
//                'unit_price' => 57.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'aran dela gal und 5/16',
//                'description' => 'Arandela Galvanizada UND 5/16',
//                'unit_price' => 50.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'wasa g 5/16',
//                'description' => 'Arandela Galvanizada G 5/16',
//                'unit_price' => 30.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'angulo de 2" x 3/16',
//                'description' => 'Ángulo de Acero 2" X 3/16',
//                'unit_price' => 187447.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'juego de boquilla imc 1 1/2 tuerca y contratuerca',
//                'description' => 'Juego de Boquilla IMC 1 1/2 con Tuerca y Contratuerca',
//                'unit_price' => 6722.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'cnect or bornera hembra macho',
//                'description' => 'Conector para Bornera Hembra Macho',
//                'unit_price' => 3361.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'curva emt 1 1/4',
//                'description' => 'Curva EMT 1 1/4',
//                'unit_price' => 6603.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'conector recto 11/4" coraza',
//                'description' => 'Conector Recto 11/4" con Coraza',
//                'unit_price' => 10924.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'entrada a caja de 1 1/4" emt acero',
//                'description' => 'Entrada a Caja de 1 1/4" EMT en Acero',
//                'unit_price' => 4117.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'prensa estopa pg-16',
//                'description' => 'Prensa Estopa PG-16',
//                'unit_price' => 546.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'union de 1 1/4" emt acero',
//                'description' => 'Unión de 1 1/4" EMT en Acero',
//                'unit_price' => 3865.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'conduleta emt lb de 3/4"',
//                'description' => 'Conduleta EMT LB de 3/4"',
//                'unit_price' => 7983.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'alurack estructura tornillo m8 x 25',
//                'description' => 'Alurack Estructura con Tornillo M8 X 25',
//                'unit_price' => 840.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'capacete de 1" aluminio',
//                'description' => 'Capacete de 1" en Aluminio',
//                'unit_price' => 3975.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tapon cuadrado plastico de 1 1/2',
//                'description' => 'Tapón Cuadrado Plástico de 1 1/2',
//                'unit_price' => 336.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'tapon rectangular 3" 1 1/2 caucho',
//                'description' => 'Tapón Rectangular 3" 1 1/2 Caucho',
//                'unit_price' => 1680.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'adaptador terminal pvc 3/4 tercol',
//                'description' => 'Adaptador Terminal PVC 3/4 Tercol',
//                'unit_price' => 180.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'amarre dexson 20cm (pqtex 100) negro',
//                'description' => 'Amarre Dexson 20CM (PQTEX 100) Negro',
//                'unit_price' => 5194.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'grapa ajustable 3/4 durman',
//                'description' => 'Grapa Ajustable 3/4 Durman',
//                'unit_price' => 692.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'union en acero emt 1',
//                'description' => 'Unión en Acero EMT 1',
//                'unit_price' => 1339.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'conector prensa ob 1010 (1/0-4)',
//                'description' => 'Conector Prensa OB 1010 (1/0-4)',
//                'unit_price' => 3394.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'boquilla dyna 3/4',
//                'description' => 'Boquilla Dyna 3/4',
//                'unit_price' => 977.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'conector resorte 18-2 rojo',
//                'description' => 'Conector Resorte 18-2 Rojo',
//                'unit_price' => 188.00,
//            ],
//            [
//                'material_category_id' => 4,
//                'reference' => 'terminal emt 1/2',
//                'description' => 'Terminal EMT 1/2',
//                'unit_price' => 829.00,
//            ],

        ];

        foreach ($materialsData as $materialData) {
            (new Material)->create($materialData);
        }
    }
}

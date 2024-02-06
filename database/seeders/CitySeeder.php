<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Department;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verificar si el departamento de Antioquia existe
        $antioquia = Department::firstOrCreate(['name' => 'Antioquia']);

        // Ciudades y/o municipios de Antioquia en orden alfabético
        $citiesDataAntioquia = [
            ['name' => 'Abejorral'],
            ['name' => 'Abriaquí'],
            ['name' => 'Alejandría'],
            ['name' => 'Amagá'],
            ['name' => 'Amalfi'],
            ['name' => 'Andes'],
            ['name' => 'Angelópolis'],
            ['name' => 'Angostura'],
            ['name' => 'Anorí'],
            ['name' => 'Santafé de Antioquia'],
            ['name' => 'Anza'],
            ['name' => 'Apartadó'],
            ['name' => 'Arboletes'],
            ['name' => 'Argelia'],
            ['name' => 'Armenia'],
            ['name' => 'Barbosa'],
            ['name' => 'Bello'],
            ['name' => 'Belmira'],
            ['name' => 'Betania'],
            ['name' => 'Betulia'],
            ['name' => 'Briceño'],
            ['name' => 'Buriticá'],
            ['name' => 'Cáceres'],
            ['name' => 'Caicedo'],
            ['name' => 'Caldas'],
            ['name' => 'Campamento'],
            ['name' => 'Cañasgordas'],
            ['name' => 'Caracolí'],
            ['name' => 'Caramanta'],
            ['name' => 'Carepa'],
            ['name' => 'Carolina del Príncipe'],
            ['name' => 'Caucasia'],
            ['name' => 'Chigorodó'],
            ['name' => 'Cisneros'],
            ['name' => 'Ciudad Bolívar'],
            ['name' => 'Cocorná'],
            ['name' => 'Concepción'],
            ['name' => 'Concordia'],
            ['name' => 'Copacabana'],
            ['name' => 'Dabeiba'],
            ['name' => 'Don Matías'],
            ['name' => 'Ebéjico'],
            ['name' => 'El Bagre'],
            ['name' => 'Entrerríos'],
            ['name' => 'Envigado'],
            ['name' => 'Fredonia'],
            ['name' => 'Frontino'],
            ['name' => 'Giraldo'],
            ['name' => 'Girardota'],
            ['name' => 'Gómez Plata'],
            ['name' => 'Granada'],
            ['name' => 'Guadalupe'],
            ['name' => 'Guarne'],
            ['name' => 'Guatapé'],
            ['name' => 'Heliconia'],
            ['name' => 'Hispania'],
            ['name' => 'Itagüí'],
            ['name' => 'Ituango'],
            ['name' => 'Jardín'],
            ['name' => 'Jericó'],
            ['name' => 'La Ceja'],
            ['name' => 'La Estrella'],
            ['name' => 'La Pintada'],
            ['name' => 'La Unión'],
            ['name' => 'Liborina'],
            ['name' => 'Maceo'],
            ['name' => 'Marinilla'],
            ['name' => 'Medellín'],
            ['name' => 'Montebello'],
            ['name' => 'Murindó'],
            ['name' => 'Mutatá'],
            ['name' => 'Nariño'],
            ['name' => 'Nechí'],
            ['name' => 'Necoclí'],
            ['name' => 'Olaya'],
            ['name' => 'Peñol'],
            ['name' => 'Peque'],
            ['name' => 'Pueblorrico'],
            ['name' => 'Puerto Berrío'],
            ['name' => 'Puerto Nare'],
            ['name' => 'Puerto Triunfo'],
            ['name' => 'Remedios'],
            ['name' => 'Retiro'],
            ['name' => 'Rionegro'],
            ['name' => 'Sabanalarga'],
            ['name' => 'Sabaneta'],
            ['name' => 'Salgar'],
            ['name' => 'San Andrés de Cuerquía'],
            ['name' => 'San Carlos'],
            ['name' => 'San Francisco'],
            ['name' => 'San Jerónimo'],
            ['name' => 'San José de la Montaña'],
            ['name' => 'San Juan de Urabá'],
            ['name' => 'San Luis'],
            ['name' => 'San Pedro'],
            ['name' => 'San Pedro de Urabá'],
            ['name' => 'San Rafael'],
            ['name' => 'San Roque'],
            ['name' => 'San Vicente'],
            ['name' => 'Santa Bárbara'],
            ['name' => 'Santa Fé de Antioquia'],
            ['name' => 'Santa Rosa de Osos'],
            ['name' => 'Santo Domingo'],
            ['name' => 'Segovia'],
            ['name' => 'Sonson'],
            ['name' => 'Sopetrán'],
            ['name' => 'Támesis'],
            ['name' => 'Tarazá'],
            ['name' => 'Tarso'],
            ['name' => 'Titiribí'],
            ['name' => 'Toledo'],
            ['name' => 'Turbo'],
            ['name' => 'Uramita'],
            ['name' => 'Urrao'],
            ['name' => 'Valdivia'],
            ['name' => 'Valparaíso'],
            ['name' => 'Vegachí'],
            ['name' => 'Venecia'],
            ['name' => 'Vigía del Fuerte'],
            ['name' => 'Yalí'],
            ['name' => 'Yarumal'],
            ['name' => 'Yolombó'],
            ['name' => 'Yondó'],
            ['name' => 'Zaragoza'],
        ];

        // Asociar las ciudades al departamento de Antioquia
        foreach ($citiesDataAntioquia as &$city) {
            $city['department_id'] = $antioquia->id;
        }

        // Usar Eloquent para insertar las ciudades de Antioquia
        City::insert($citiesDataAntioquia);

        // Verificar si el departamento de Cundinamarca existe
        $cundinamarca = Department::firstOrCreate(['name' => 'Cundinamarca']);

        // Ciudades y/o municipios de Cundinamarca en orden alfabético
        $citiesDataCundinamarca = [
            ['name' => 'Agua de Dios'],
            ['name' => 'Anapoima'],
            ['name' => 'Anolaima'],
            ['name' => 'Apulo'],
            ['name' => 'Arbeláez'],
            ['name' => 'Bituima'],
            ['name' => 'Bogotá D.C.'],
            ['name' => 'Cabrera'],
            ['name' => 'Cajicá'],
            ['name' => 'Caparrapí'],
            ['name' => 'Carmen de Carupa'],
            ['name' => 'Cota'],
            ['name' => 'Cucunubá'],
            ['name' => 'Chaguaní'],
            ['name' => 'Chía'],
            ['name' => 'Chocontá'],
            ['name' => 'Cogua'],
            ['name' => 'Cota'],
            ['name' => 'El Colegio'],
            ['name' => 'El Guamo'],
            ['name' => 'El Peñón'],
            ['name' => 'El Rosal'],
            ['name' => 'Facatativá'],
            ['name' => 'Fomeque'],
            ['name' => 'Fusagasugá'],
            ['name' => 'Funza'],
            ['name' => 'Gachancipá'],
            ['name' => 'Gachetá'],
            ['name' => 'Girardot'],
            ['name' => 'Guaduas'],
            ['name' => 'Guatavita'],
            ['name' => 'Gutiérrez'],
            ['name' => 'Jerusalén'],
            ['name' => 'La Calera'],
            ['name' => 'La Mesa'],
            ['name' => 'La Palma'],
            ['name' => 'La Peña'],
            ['name' => 'Madrid'],
            ['name' => 'Mosquera'],
            ['name' => 'Nariño'],
            ['name' => 'Nemocón'],
            ['name' => 'Nilo'],
            ['name' => 'Nocaima'],
            ['name' => 'Pacho'],
            ['name' => 'Paime'],
            ['name' => 'Pandi'],
            ['name' => 'Pulí'],
            ['name' => 'Quebradanegra'],
            ['name' => 'Quetame'],
            ['name' => 'Quipile'],
            ['name' => 'Ricaurte'],
            ['name' => 'San Antonio del Tequendama'],
            ['name' => 'San Bernardo'],
            ['name' => 'San Cayetano'],
            ['name' => 'San Francisco'],
            ['name' => 'San Juan de Río Seco'],
            ['name' => 'San Juan de Rioseco'],
            ['name' => 'Sasaima'],
            ['name' => 'Sesquilé'],
            ['name' => 'Sibaté'],
            ['name' => 'Simijaca'],
            ['name' => 'Soacha'],
            ['name' => 'Sopó'],
            ['name' => 'Supatá'],
            ['name' => 'Suesca'],
            ['name' => 'Sutatausa'],
            ['name' => 'Tabio'],
            ['name' => 'Tausa'],
            ['name' => 'Tena'],
            ['name' => 'Tibacuy'],
            ['name' => 'Tibiritá'],
            ['name' => 'Tocaima'],
            ['name' => 'Tocancipá'],
            ['name' => 'Topaipí'],
            ['name' => 'Ubaté'],
            ['name' => 'Une'],
            ['name' => 'Vergara'],
            ['name' => 'Viani'],
            ['name' => 'Villagómez'],
            ['name' => 'Villapinzón'],
            ['name' => 'Viotá'],
            ['name' => 'Yacopí'],
            ['name' => 'Zipacón'],
            ['name' => 'Zipaquirá']
        ];

        // Asociar las ciudades de Cundinamarca al departamento
        foreach ($citiesDataCundinamarca as &$city) {
            $city['department_id'] = $cundinamarca->id;
        }

        // Usar Eloquent para insertar las ciudades de Cundinamarca
        City::insert($citiesDataCundinamarca);

        // Agregar ciudades ficticias para otros departamentos o provincias de diferentes países
        // ... [nombre_del_departamento] = [ciudad1, ciudad2, ciudad3]
        $citiesDataOtherDepartments = [
            // Argentina
            'Buenos Aires' => ['La Plata', 'Mar del Plata', 'Quilmes'],
            'Córdoba' => ['Córdoba Capital', 'Villa María', 'Río Cuarto'],
            'Mendoza' => ['Mendoza Capital', 'San Rafael', 'Godoy Cruz'],

            // México
            'Mexico City' => ['Mexico City Centro', 'Coyoacán', 'Polanco'],
            'Jalisco' => ['Guadalajara', 'Zapopan', 'Tlaquepaque'],
            'Nuevo León' => ['Monterrey', 'San Pedro Garza García', 'Guadalupe'],

            // España
            'Madrid' => ['Madrid Capital', 'Alcalá de Henares', 'Majadahonda'],
            'Barcelona' => ['Barcelona Capital', 'Badalona', 'Hospitalet de Llobregat'],
            'Valencia' => ['Valencia Capital', 'Gandía', 'Sagunto'],

            // Brasil
            'São Paulo' => ['São Paulo Capital', 'Guarulhos', 'Campinas'],
            'Rio de Janeiro' => ['Rio de Janeiro Capital', 'Niterói', 'São Gonçalo'],
            'Bahia' => ['Salvador', 'Feira de Santana', 'Vitória da Conquista'],

            // Chile
            'Santiago' => ['Santiago Centro', 'Providencia', 'Las Condes'],
            'Valparaíso' => ['Valparaíso Capital', 'Viña del Mar', 'Quilpué'],
            'Biobío' => ['Concepción', 'Talcahuano', 'Chillán'],
        ];

        foreach ($citiesDataOtherDepartments as $departmentName => $cities) {
            $department = Department::firstOrCreate(['name' => $departmentName]);

            foreach ($cities as &$city) {
                $cityData = ['name' => $city, 'department_id' => $department->id];
                City::create($cityData);
            }
        }
    }
}

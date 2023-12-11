<x-guest-layout>
    <x-welcome-navbar />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manual de Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">


                    <!-- Manual de Usuario -->
                    <div>
                        <h1 class="text-4xl font-bold mb-6">Manual de Usuario</h1>
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            Bienvenido al Manual de Usuario de Quick Quote GSV Ingeniería. Este manual te guiará a través de todas las funciones y características de nuestra plataforma de cotizaciones. Ya sea que seas nuevo en la plataforma o un usuario experimentado, este manual proporciona información detallada para maximizar tu experiencia y aprovechar al máximo todas las capacidades de Quick Quote.
                        </p>

                        <!-- Contenido específico del Manual de Usuario aquí -->

                        <div class="mt-8">
                            <!-- Ejemplo de sección del manual -->
                            <h2 class="text-2xl font-semibold mb-4">Inicio de Sesión</h2>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                Aprende a iniciar sesión en Quick Quote GSV Ingeniería. Este proceso te permitirá acceder a todas las funciones y comenzar a trabajar en tus cotizaciones. Sigue los pasos detallados en esta sección para garantizar un acceso seguro y eficiente a la plataforma.
                            </p>

                            <!-- Agrega más secciones y detalles del manual según sea necesario -->

                            <!-- Ejemplo de otra sección del manual -->
                            <h2 class="text-2xl font-semibold mb-4">Creación de Cotizaciones</h2>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                Descubre cómo crear cotizaciones precisas y atractivas utilizando Quick Quote. Desde la entrada de datos del cliente hasta la generación del presupuesto final, esta sección te guiará a través de cada paso del proceso de creación de cotizaciones.
                            </p>

                            <!-- Más contenido del Manual de Usuario -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>

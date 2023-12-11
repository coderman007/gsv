<x-guest-layout>
    <x-welcome-navbar />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuraciones') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

                    <!-- Configuraciones -->
                    <div>
                        <h1 class="text-4xl font-bold mb-6">Configuraciones</h1>
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            Bienvenido a la sección de configuraciones de Quick Quote GSV Ingeniería. Aquí puedes personalizar tu experiencia y ajustar la plataforma según tus necesidades empresariales. Las configuraciones te permiten adaptar el sistema de cotizaciones a los requisitos específicos de tu empresa, mejorando así tu eficiencia y productividad.
                        </p>

                        <!-- Contenido específico de configuraciones aquí -->

                        <div class="mt-8">
                            <!-- Ejemplo de configuración -->
                            <h2 class="text-2xl font-semibold mb-4">Configuración de Notificaciones</h2>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                Personaliza las notificaciones para mantener a tu equipo informado sobre actualizaciones importantes, nuevos clientes y cambios en las cotizaciones. Asegúrate de configurar las preferencias de notificación de acuerdo con las necesidades de tu equipo y la operación diaria de tu empresa.
                            </p>

                            <!-- Agrega más secciones y detalles de configuración según sea necesario -->

                            <!-- Ejemplo de otra configuración -->
                            <h2 class="text-2xl font-semibold mb-4">Configuración de Tema</h2>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                Personaliza la apariencia visual de Quick Quote GSV Ingeniería. Puedes elegir entre diferentes temas, incluyendo el modo oscuro para reducir la fatiga visual. Ajusta el tema según tus preferencias personales o para cumplir con los estándares de diseño de tu empresa.
                            </p>

                            <!-- Más contenido de configuración -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>

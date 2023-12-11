<x-guest-layout>
    <x-welcome-navbar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div class="col-span-1">
                        <h1 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                            Bienvenid@ a Quick Quote GSV Ingeniería
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            Tu herramienta de cotización empresarial ahora en versión de escritorio. Quick Quote GSV Ingeniería simplifica el proceso de cotización de sistemas fotovoltaicos para que puedas centrarte en lo que realmente importa: hacer crecer tu negocio.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            Con una interfaz de usuario intuitiva y funciones personalizables, Quick Quote se adapta a tus necesidades. Genera cotizaciones precisas y atractivas con facilidad, incluso cuando estás fuera de línea.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            Características destacadas:
                        </p>
                        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6">
                            <li>Interfaz de usuario amigable.</li>
                            <li>Generación de cotizaciones sin conexión a internet.</li>
                            <li>Personalización de configuraciones para adaptarse a tu flujo de trabajo.</li>
                            <li>Experiencia de usuario fluida y eficiente.</li>
                        </ul>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            pulsa aquí abajo para comenzar.
                        </p>
                        <a href="{{route('login')}}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                            Comenzar
                        </a>
                    </div>
                    <div class="col-span-1 hidden bg-gray-400 md:flex items-center shadow-lg shadow-gray-300 justify-center">
                        <!-- Agrega aquí una imagen o gráfico representativo si lo deseas -->
                        <img src="{{ asset('images/solar3.webp') }}" alt="Imagen representativa" class="w-full h-auto rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

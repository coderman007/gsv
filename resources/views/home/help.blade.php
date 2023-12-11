<x-guest-layout>
    <x-welcome-navbar />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ayuda y Soporte') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <!-- Ayuda -->
                    <!-- Contenido Principal de Ayuda y Soporte -->
                    <div>
                        <!-- Sección 1: Bienvenida -->
                        <h1 class="text-4xl font-bold mb-6">Centro de Ayuda y Soporte</h1>
                        <div class="prose">
                            <h2 class="dark:text-white">¡Bienvenido a nuestra sección de Ayuda y Soporte!</h2>
                            <p class="dark:text-gray-300">Estamos aquí para asistirte en el uso de Quick Quote GSV Ingeniería. Si encuentras algún problema o necesitas orientación, revisa las secciones a continuación o contáctanos directamente.</p>
                        </div>

                        <!-- Sección 1: Introducción -->
                        <section class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Introducción</h2>
                            <p>En el Centro de Ayuda encontrarás recursos detallados para ayudarte a aprovechar al máximo nuestra plataforma de cotizaciones de sistemas fotovoltaicos. Descubre cómo maximizar la eficiencia de tu trabajo y optimizar tus resultados.</p>
                        </section>

                        <!-- Sección 2: Primeros Pasos -->
                        <section class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Primeros Pasos</h2>
                            <p>Aprende a registrarte, iniciar sesión y explorar las funciones básicas de Quick Quote GSV Ingeniería. Comienza tu experiencia de manera rápida y sencilla.</p>
                            <p>Puedes ver tutoriales detallados, videos instructivos y enlaces a recursos específicos en esta sección para facilitar tu proceso de inicio.</p>
                        </section>

                        <!-- Sección 2: Cómo Crear una Cotización -->
                        <section class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Cómo Crear una Cotización</h2>
                            <p>Descubre el proceso detallado para crear cotizaciones precisas, incluyendo la entrada de datos del cliente, configuración de políticas y la generación del presupuesto final. Aprende a utilizar cada función de manera efectiva para proporcionar presupuestos precisos y atractivos.</p>
                            <p>Encuentra tutoriales detallados, imágenes y instrucciones paso a paso para facilitar el proceso de creación de cotizaciones.</p>
                        </section>

                        <!-- Sección 3: Preguntas Frecuentes -->
                        <section class="mb-8">
                            <h2 class="dark:text-white">Preguntas Frecuentes</h2>
                            <p class="dark:text-gray-300">Consulta nuestra lista de preguntas frecuentes para obtener respuestas rápidas a las dudas más comunes. Aquí encontrarás información sobre problemas comunes, soluciones rápidas y consejos útiles.</p>
                        </section>

                        <!-- Sección 4: Tutoriales -->
                        <section class="mb-8">
                            <h2 class="dark:text-white">Tutoriales</h2>
                            <p class="dark:text-gray-300">Explora nuestra serie de tutoriales paso a paso para aprender a utilizar todas las funciones y características de Quick Quote GSV Ingeniería. Desde funciones básicas hasta avanzadas, estos tutoriales te guiarán en cada paso.</p>
                        </section>

                        <!-- Sección 3: Configuraciones del Sistema -->
                        <section class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Configuraciones del Sistema</h2>
                            <p>Explora las opciones de configuración disponibles y personaliza tu experiencia en Quick Quote GSV Ingeniería. Ajusta las configuraciones según tus preferencias y necesidades específicas para optimizar tu flujo de trabajo.</p>
                            <p>Encuentra tutoriales detallados, imágenes y guías paso a paso para realizar configuraciones personalizadas de manera eficiente.</p>
                        </section>

                        <!-- Sección 4: Contacto de Soporte -->
                        <section class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Contacto de Soporte</h2>
                            <p>Si necesitas asistencia adicional, nuestro equipo de soporte está listo para ayudarte. Utiliza el formulario de contacto o envía un correo electrónico a support@quickquote.com. Nos comprometemos a responder rápidamente y proporcionar la ayuda que necesitas.</p>

                            <p>Si no encuentras la respuesta que buscas, no dudes en ponerte en contacto con nuestro equipo de soporte. Estamos aquí para ayudarte. Utiliza el formulario de contacto o envía un correo electrónico a support@quickquote.com.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

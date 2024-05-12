<div class="relative inline-block text-center cursor-pointer group">
    <!-- Botón para abrir el diálogo modal -->
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <!-- Tooltip que aparece al pasar el ratón -->
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"></svg>
        </div>
    </a>

    <!-- Diálogo modal para mostrar detalles de la política comercial -->
    <x-dialog-modal wire:model="openShow">
        <x-slot name="title">
            <!-- Cambiar color del título a azul -->
            <div class="text-center text-blue-500 text-xl">Detalles de la Política Comercial</div>
        </x-slot>

        <x-slot name="content">
            <!-- Cambiar el fondo a blanco, con un borde suave para diferenciar -->
            <div class="md:px-5 pb-5 bg-white rounded-lg shadow p-6">
                <div class="md:mx-6">
                    <!-- Cambiar estilo de texto a gris oscuro, con tonos más consistentes -->
                    <h3 class="text-xl font-semibold text-gray-800">{{ $commercialPolicy->name }}</h3>
                    <p class="p-2 text-lg text-gray-700">
                        Porcentaje: {{ $commercialPolicy->percentage }}%
                    </p>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-4 p-4 border-t border-gray-300">
                <!-- Cambiar color del botón a azul para consistencia -->
                <a href="#" wire:click="$set('openShow', false)"
                   class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition duration-200">
                    Salir
                </a>
            </div>
        </x-slot>

    </x-dialog-modal>
</div>

<div>
    <!-- Botón para abrir el diálogo -->
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa fa-solid fa-plus text-xl"></i> Agregar
        </span>
    </button>

    <!-- Diálogo modal para crear una nueva política comercial -->
    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <div class="my-4 text-center text-blue-500 text-xl">
                Crear Política Comercial
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- Sección para la creación de la política comercial -->
            <div class="mt-5 bg-white rounded-lg shadow p-6">
                <!-- Campo para el nombre de la política -->
                <div>
                    <x-label class="text-left text-lg text-gray-700" value="Nombre de la Política" />
                    <input wire:model="name" type="text"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <!-- Muestra errores de validación, si existen -->
                    <x-input-error for="name" />
                </div>

                <!-- Campo para el porcentaje -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Porcentaje (%)" />
                    <input wire:model="percentage" type="number" step="1" min=0 max=100
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="percentage" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-4 p-4 border-t border-gray-300">
                <!-- Botón para cancelar y cerrar el diálogo -->
                <button wire:click="$toggle('openCreate')"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition duration-200">
                    Salir
                </button>

                <!-- Botón para crear la política comercial -->
                <button wire:click="createCommercialPolicy"
                        wire:loading.attr="disabled"
                        wire:target="createCommercialPolicy"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none transition duration-200">
                    Crear
                </button>
            </div>
        </x-slot>

    </x-dialog-modal>

</div>


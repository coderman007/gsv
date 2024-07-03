<div>
    <!-- Botón para abrir el diálogo de edición -->
    <div class="relative inline-block text-center cursor-pointer group">
        <a href="#" wire:click="$set('openEdit', true)">
            <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
                <i class="fa fa-pen-to-square"></i>
            </div>
            <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
                Editar
                <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                </svg>
            </div>
        </a>
    </div>

    <!-- Diálogo modal para editar un transporte -->
    <x-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <div class="my-4 text-center text-blue-500 text-xl">
                Editar Transporte
            </div>
        </x-slot>
        <x-slot name="content">
            <!-- Sección para el tipo de vehículo -->
            <div class="mt-5 bg-white rounded-lg shadow p-6">
                <!-- Tipo de Vehículo -->
                <div class="mb-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Vehículo" />
                    <!-- Mostrar el tipo de vehículo actual -->
                    <div class="flex items-center mt-2">
                        <input type="text" wire:model="vehicle_type" class="text-gray-800 w-full px-4 py-2.5 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <!-- Muestra errores de validación, si existen -->
                    <x-input-error for="vehicle_type" />
                </div>

                <!-- Capacidad -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Capacidad" />
                    <input wire:model="capacity" type="number" class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="capacity" />
                </div>

                <!-- Costo por día -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo por Día" />
                    <input wire:model="cost_per_day" type="number" class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="cost_per_day" />
                </div>

                <!-- Tipo de combustible -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Combustible" />
                    <input wire:model="fuel_type" type="text" class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="fuel_type" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-4 p-4 border-t border-gray-300">
                <!-- Botón para cancelar y cerrar el diálogo -->
                <button wire:click="$toggle('openEdit')" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition duration-200">
                    Salir
                </button>

                <!-- Botón para actualizar el transporte -->
                <button wire:click="updateTransport" wire:loading.attr="disabled" wire:target="updateTransport" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none transition duration-200">
                    Guardar Cambios
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

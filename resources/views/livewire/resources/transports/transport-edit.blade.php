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
            <div class="my-4 text-center text-gray-500 text-xl">
                Editar Transporte
            </div>
        </x-slot>
        <x-slot name="content">
            <!-- Sección para el tipo de vehículo -->
            <div class="mt-5 bg-white rounded-lg border border-fuchsia-500 p-6">
                <!-- Tipo de Vehículo -->
                <div class="mb-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Vehículo" />
                    <!-- Mostrar el tipo de vehículo actual -->
                    <div class="flex items-center mt-2">
                        <input type="text" wire:model="vehicle_type" class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    </div>
                    <!-- Muestra errores de validación, si existen -->
                    <x-input-error for="vehicle_type" />
                </div>

                <!-- Capacidad -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Capacidad" />
                    <input wire:model="capacity" type="number" class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="capacity" />
                </div>

                <!-- Costo por día -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo por Día" />
                    <input wire:model="cost_per_day" type="number" class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="cost_per_day" />
                </div>

                <!-- Tipo de combustible -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Combustible" />
                    <input wire:model="fuel_type" type="text" class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="fuel_type" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between gap-4 text-lg">
                <button type="button" wire:click="$set('openEdit', false)"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-ban mr-2"></i> Cancelar
                </button>
                <button type="submit" wire:click="updateTransport"
                        class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-pen-to-square mr-2 text-xl"></i> Actualizar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

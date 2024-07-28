<div>
    <!-- Botón para abrir el diálogo -->
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -tranfuchsia-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-tranfuchsia-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <div class="flex items-center"><i class="fa-solid fa-truck text-xl mr-2"></i> Nuevo Transporte</div>
        </span>
    </button>

    <!-- Diálogo modal para crear un nuevo transporte -->
    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <div class="my-4 text-center text-gray-500 text-xl">
                Crear Transporte
            </div>
        </x-slot>
        <x-slot name="content">
            <!-- Sección para el tipo de vehículo -->
            <div class="mt-5 bg-white rounded-lg border border-fuchsia-500 p-6">
                <!-- Tipo de Vehículo -->
                <div>
                    <x-label class="text-left text-lg text-gray-700" value="Vehículo" />
                    <input wire:model="vehicle_type"
                           class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="vehicle_type" />
                </div>

                <!-- Costo por día -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo Diario" />
                    <input wire:model="cost_per_day" type="number"
                           class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="cost_per_day" />
                </div>

                <!-- Capacidad -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Capacidad" />
                    <input wire:model="capacity" type="number"
                           class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="capacity" />
                </div>

                <!-- Tipo de combustible -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Combustible" />
                    <input wire:model="fuel_type" type="text"
                           class="bg-fuchsia-50 border border-fuchsia-300 text-gray-500 text-sm rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-fuchsia-500 dark:focus:border-fuchsia-500">
                    <x-input-error for="fuel_type" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between gap-4 text-lg">
                <button type="button" wire:click="$set('openCreate', false)"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-ban mr-2"></i> Cancelar
                </button>
                <button type="submit"
                        wire:click="createTransport"
                        wire:loading.attr="disabled"
                        wire:target="createTransport"
                        class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-regular fa-floppy-disk mr-2 text-xl"></i> Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

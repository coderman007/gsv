<div>
    <!-- Botón para abrir el diálogo -->
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa fa-solid fa-plus text-xl"></i> Nuevo Transporte
        </span>
    </button>

    <!-- Diálogo modal para crear un nuevo transporte -->
    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <div class="my-4 text-center text-blue-500 text-xl">
                Crear Transporte
            </div>
        </x-slot>
        <x-slot name="content">
            <!-- Sección para el tipo de vehículo -->
            <div class="mt-5 bg-white rounded-lg shadow p-6">
                <!-- Tipo de Vehículo (Dropdown) -->
                <div>
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Vehículo" />
                    <!-- Menú desplegable para seleccionar el tipo de vehículo -->
                    <select wire:model="vehicle_type"
                            class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona un tipo de vehículo</option>
                        <option value="motocicleta">Motocicleta</option>
                        <option value="automóvil">Automóvil</option>
                        <option value="camión">Camión</option>
                        <option value="autobús">Autobús</option>
                        <option value="van">Van</option>
                        <option value="otro">Otro</option>
                    </select>
                    <!-- Muestra errores de validación, si existen -->
                    <x-input-error for="vehicle_type" />
                </div>

                <!-- Costo por día -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo por Día" />
                    <input wire:model="cost_per_day" type="number"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="cost_per_day" />
                </div>

                <!-- Capacidad -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Capacidad" />
                    <input wire:model="capacity" type="number"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="capacity" />
                </div>

                <!-- Tipo de combustible -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Combustible" />
                    <input wire:model="fuel_type" type="text"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="fuel_type" />
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

                <!-- Botón para crear el transporte -->
                <button wire:click="createTransport"
                        wire:loading.attr="disabled"
                        wire:target="createTransport"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none transition duration-200">
                    Crear
                </button>
            </div>
        </x-slot>

    </x-dialog-modal>
</div>

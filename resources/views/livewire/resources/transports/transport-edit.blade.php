<div>
    <div class="relative inline-block text-center cursor-pointer group">
        <a href="#" wire:click="$set('openEdit', true)">
            <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
                <i class="fa-solid fa-pen-to-square"></i>
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
                <!-- Tipo de Vehículo (Dropdown) -->
                <div>
                    <x-label class="text-left text-lg text-gray-700" value="Tipo de Vehículo" />
                    <!-- Menú desplegable para seleccionar el tipo de vehículo -->
                    <select wire:model="vehicle_type"
                            class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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

                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo gasolina por km" />
                    <input wire:model="gasoline_cost_per_km" type="number"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="gasoline_cost_per_km" />
                </div>

                <!-- Costo por día -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo por Día" />
                    <input wire:model="cost_per_day" type="number"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="cost_per_day" />
                </div>

                <!-- Costo Peaje -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Costo Peaje" />
                    <input wire:model="toll_cost" type="number"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="toll_cost" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-4 p-4 border-t border-gray-300">
                <!-- Botón para cancelar y cerrar el diálogo -->
                <button wire:click="$toggle('openEdit')"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition duration-200">
                    Salir
                </button>

                <!-- Botón para actualizar el transporte -->
                <button wire:click="updateTransport"
                        wire:loading.attr="disabled"
                        wire:target="updateTransport"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none transition duration-200">
                    Guardar Cambios
                </button>
            </div>
        </x-slot>

    </x-dialog-modal>
</div>

<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <i class="p-1 text-blue-400 rounded hover:text-white hover:bg-blue-500 fa-solid fa-pen-to-square"></i>
        <div class="absolute z-10 px-3 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-6">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Actualizar Usuario</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <form>
                    <!-- Nombre -->
                    <x-label value="Nombre" class="text-gray-700" />
                    <x-input class="w-full" wire:model="name" />
                    <x-input-error for="name" />

                    <!-- Dirección -->
                    <x-label value="Dirección" class="text-gray-700" />
                    <x-input class="w-full" wire:model="address" />
                    <x-input-error for="address" />

                    <!-- Teléfono -->
                    <x-label value="Teléfono" class="text-gray-700" />
                    <x-input class="w-full" wire:model="phone" />
                    <x-input-error for="phone" />

                    <!-- Correo Electrónico -->
                    <x-label value="Correo Electrónico" class="text-gray-700" />
                    <x-input class="w-full" wire:model="email" type="email" />
                    <x-input-error for="email" />

                    <!-- Consumo promedio -->
                    <x-label value="Consumo Promedio" class="text-gray-700" />
                    <x-input class="w-full" wire:model="average_energy_consumption" type="number" />
                    <x-input-error for="average_energy_consumption" />

                    <!-- Nivel de Radiación Solar -->
                    <div class="mb-4">
                        <label for="solar_radiation_level" class="block text-sm font-medium text-gray-700">Nivel de Radiación Solar</label>
                        <input type="number" wire:model="solar_radiation_level" id="solar_radiation_level" name="solar_radiation_level" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('solar_radiation_level') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dimensiones de Cubierta (Largo) -->
                    <x-label value="Dimensiones de Cubierta (Largo)" class="text-gray-700" />
                    <x-input class="w-full" wire:model="roof_dimensions_length" type="number" />
                    <x-input-error for="roof_dimensions_length" />

                    <!-- Dimensiones de Cubierta (Ancho) -->
                    <x-label value="Dimensiones de Cubierta (Ancho)" class="text-gray-700" />
                    <x-input class="w-full" wire:model="roof_dimensions_width" type="number" />
                    <x-input-error for="roof_dimensions_width" />

                    <!-- Dropdown para Estado -->
                    <x-label value="Estado" class="text-gray-700" />
                    <select class="w-full mb-4 rounded-md" wire:model="status">
                        <option value="" disabled>Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                    <x-input-error for="status" />
                </form>

            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <x-secondary-button wire:click="$set('openEdit', false)" class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                        Cancelar
                    </x-secondary-button>
                    <x-secondary-button class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white" wire:click="updateClient" wire:loading.attr="disabled" wire:target="updateClient">
                        Actualizar
                    </x-secondary-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

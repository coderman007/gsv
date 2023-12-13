<div>
    <button wire:click="$set('openCreate', true)" class="absolute right-10 top-10 mt-8 px-4 py-2 rounded-md text-blue-500 bg-blue-100 border border-blue-500 shadow-md hover:shadow-blue-400 hover:bg-blue-400 hover:text-white">
        <i class="fa fa-solid fa-user-plus text-xl"></i> Agregar
    </button>

    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Cliente</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <form>
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" wire:model="name" id="name" name="name" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" wire:model="address" id="address" name="address" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" wire:model="phone" id="phone" name="phone" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" wire:model="email" id="email" name="email" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Consumo de Energía Promedio -->
                    <div class="mb-4">
                        <label for="average_energy_consumption" class="block text-sm font-medium text-gray-700">Consumo de Energía Promedio</label>
                        <input type="number" wire:model="average_energy_consumption" id="average_energy_consumption" name="average_energy_consumption" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('average_energy_consumption') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nivel de Radiación Solar -->
                    <div class="mb-4">
                        <label for="solar_radiation_level" class="block text-sm font-medium text-gray-700">Nivel de Radiación Solar</label>
                        <input type="number" wire:model="solar_radiation_level" id="solar_radiation_level" name="solar_radiation_level" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('solar_radiation_level') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Longitud Cubierta -->
                    <div class="mb-4">
                        <label for="roof_dimensions_length" class="block text-sm font-medium text-gray-700">Longitud Cubierta</label>
                        <input type="number" wire:model="roof_dimensions_length" id="roof_dimensions_length" name="roof_dimensions_length" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('roof_dimensions_length') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ancho Cubierta -->
                    <div class="mb-4">
                        <label for="roof_dimensions_width" class="block text-sm font-medium text-gray-700">Ancho Cubierta</label>
                        <input type="number" wire:model="roof_dimensions_width" id="roof_dimensions_width" name="roof_dimensions_width" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('roof_dimensions_width') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dropdown para Estado -->
                    <x-label value="Estado" class="text-gray-700" />
                    <select class="w-full mb-4 rounded-md" wire:model.blur="status">
                        <option value="" disabled>Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                    <x-input-error for="status" />
                </form>

            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <x-secondary-button wire:click="$set('openCreate', false)" class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                        Cancelar
                    </x-secondary-button>
                    <x-secondary-button class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white" wire:click="createClient" wire:loading.attr="disabled" wire:target="createClient">
                        Agregar
                    </x-secondary-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

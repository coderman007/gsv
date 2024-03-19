<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Proyecto</span>
    </button>

    <x-dialog-modal maxWidth="7xl" wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Proyecto</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <div>
                    <form wire:submit.prevent="saveProject" class="p-4 bg-white rounded shadow-md">

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Nombre del Proyecto -->
                            <div class="mb-4">
                                <label for="name" class="text-lg font-semibold text-gray-600 py-2">Nombre del
                                    Proyecto</label>
                                <input wire:model="name" type="text" id="name" name="name"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Descripción del Proyecto -->
                            <div class="mb-4">
                                <label for="description" class="text-lg font-semibold text-gray-600 py-2">Descripción
                                    del
                                    Proyecto</label>
                                <textarea wire:model="description" id="description" name="description" rows="3"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md"></textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Kilovatios a Proveer -->
                            <div class="mb-4">
                                <label for="kilowatts_to_provide"
                                    class="text-lg font-semibold text-gray-600 py-2">Kilovatios
                                    a Proveer</label>
                                <input wire:model="kilowatts_to_provide" type="number" id="kilowatts_to_provide"
                                    name="kilowatts_to_provide"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('kilowatts_to_provide')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Estado del Proyecto -->
                            <div class="mb-4">
                                <label for="status" class="text-lg font-semibold text-gray-600 py-2">Estado del
                                    Proyecto</label>
                                <select wire:model="status" id="status" name="status"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <label class="text-lg font-semibold text-gray-600 py-2">
                            <h3 class="mb-2">Mano de Obra</h3>
                            <!-- Selección de Posiciones y Configuración -->
                            <div class="mb-4 grid grid-cols-4 gap-4">
                                @foreach ($allPositions as $position)
                                    <!-- Columna 1: Checkbox -->
                                    <div class="flex items-center col-span-2">
                                        <input wire:model.live="selectedPositions" type="checkbox"
                                            value="{{ $position->id }}" id="position{{ $position->id }}"
                                            class="mr-2 border-gray-300 rounded shadow-sm text-blue-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <label for="position{{ $position->id }}"
                                            class="block text-sm font-medium text-gray-700">{{ $position->name }}</label>
                                    </div>
                                    <!-- Columna 2: Cantidad -->
                                    <div class="col-span-1">
                                        @if (in_array($position->id, $selectedPositions))
                                            <div class="mb-2">
                                                <label for="quantity{{ $position->id }}"
                                                    class="block text-sm font-medium text-gray-700">Cantidad</label>
                                                <input wire:model.live="positionQuantities.{{ $loop->index }}"
                                                    type="number" id="quantity{{ $position->id }}"
                                                    name="quantity{{ $position->id }}"
                                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                                @error('positionQuantities.' . $loop->index)
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Columna 3: Días Requeridos -->
                                    <div class="col-span-1">
                                        @if (in_array($position->id, $selectedPositions))
                                            <div class="mb-2">
                                                <label for="requiredDays{{ $position->id }}"
                                                    class="block text-sm font-medium text-gray-700">Días
                                                    Requeridos</label>
                                                <input wire:model.live="positionRequiredDays.{{ $loop->index }}"
                                                    type="number" id="requiredDays{{ $position->id }}"
                                                    name="requiredDays{{ $position->id }}"
                                                    class="mt1 p-2 block w-full border-gray-300 rounded-md">
                                                @error('positionRequiredDays.' . $loop->index)
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @error('selectedPositions')
                                    <span class="col-span-8 text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </label>

                        <!-- Materiales -->
                        <label for="material" class="text-lg font-semibold text-gray-600 py-2">
                            Material
                        </label>
                        <input type="text" id="material" wire:model.live="searchMaterial"
                            placeholder="Buscar material"
                            class="form-input rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 w-full">
                        @if ($filteredMaterials && count($filteredMaterials) > 0)
                            <ul class="mt-2 border border-gray-300 rounded-md shadow-sm absolute z-10 bg-white w-full">
                                @foreach ($filteredMaterials as $filteredMaterial)
                                    <li class="py-1 px-3 cursor-pointer hover:bg-gray-100"
                                        wire:click="selectMaterial('{{ $filteredMaterial->id }}', '{{ $filteredMaterial->name }}')">
                                        {{ $filteredMaterial->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <x-input-error for="searchMaterial" />


                        <!-- Resto del formulario... -->

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition duration-150 ease-in-out">
                                Guardar Proyecto
                            </button>
                        </div>
                    </form>
                </div>
            </x-slot>

            <x-slot name="footer">
            </x-slot>
    </x-dialog-modal>
</div>

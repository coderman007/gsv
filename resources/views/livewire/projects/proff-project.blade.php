<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Proyecto</span>
    </button>

    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Proyecto</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <div>
                    <form wire:submit.prevent="saveProject" class="p-4 bg-white rounded shadow-md">
                        <!-- Nombre del Proyecto -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del
                                Proyecto</label>
                            <input wire:model.defer="name" type="text" id="name" name="name"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Descripción del Proyecto -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descripción del
                                Proyecto</label>
                            <textarea wire:model.defer="description" id="description" name="description" rows="3"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md"></textarea>
                            @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kilovatios a Proveer -->
                        <div class="mb-4">
                            <label for="kilowatts_to_provide" class="block text-sm font-medium text-gray-700">Kilovatios
                                a Proveer</label>
                            <input wire:model.defer="kilowatts_to_provide" type="number" id="kilowatts_to_provide"
                                name="kilowatts_to_provide" class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('kilowatts_to_provide')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Estado del Proyecto -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado del
                                Proyecto</label>
                            <select wire:model.defer="status" id="status" name="status"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            @error('status')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Selección de Posiciones -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Posiciones</label>
                            <select wire:model.live="selectedPosition"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md">

                                <option value="">-- Seleccione una posición --</option>
                                <option value="new">Crear Nueva Posición</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                            {{ $position->name }}
                            @error('selectedPosition')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror

                            <!-- Mostrar campos adicionales para una nueva posición -->
                            @if ($selectedPosition === 'new')
                                <div class="mt-4">
                                    <label for="positionQuantity"
                                        class="block text-sm font-medium text-gray-700">Cantidad</label>
                                    <input wire:model.defer="positionQuantity" type="number" id="positionQuantity"
                                        name="positionQuantity"
                                        class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                    @error('positionQuantity')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror

                                    <label for="positionRequiredDays"
                                        class="block text-sm font-medium text-gray-700 mt-4">Días Requeridos</label>
                                    <input wire:model.defer="positionRequiredDays" type="number"
                                        id="positionRequiredDays" name="positionRequiredDays"
                                        class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                    @error('positionRequiredDays')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Cantidad y Días de Posiciones -->
                        <!-- Aquí se repetiría la estructura similar para los otros recursos: Materiales, Herramientas y Transporte -->

                        <!-- Botón de Guardar -->
                        <div class="mb-4">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar
                                Proyecto</button>
                        </div>
                    </form>
                </div>

            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <x-secondary-button wire:click="$set('openCreate', false)"
                        class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                        Cancelar
                    </x-secondary-button>
                    <x-secondary-button
                        class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                        wire:click="createProject" wire:loading.attr="disabled" wire:target="createProject">
                        Agregar
                    </x-secondary-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

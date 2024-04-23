<div>
    <x-info-button wire:click="$set('openCreate', true)">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo APU
    </x-info-button>

    <x-dialog-modal maxWidth="7xl" wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo APU</h2>
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-2 rounded-lg">
                <!-- Columna izquierda -->
                <div class="col-span-1 bg-white p-4 rounded-lg">
                    <!-- Título -->
                    <h2 class="text-center text-2xl font-bold mb-4">Formulario</h2>

                    <!-- Contenedor de información -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Columna Izquierda -->
                        <div class="col-span-1">
                            <div class="mb-4">
                                <label for="project_category" class="text-lg font-semibold text-gray-600 py-2">Categoría</label>
                                <select wire:model="selectedCategory" id="project_category" name="project_category"
                                        class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                    @if ($categories)
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('selectedCategory')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="kilowatts_to_provide" class="text-lg font-semibold text-gray-600 py-2">Potencia</label>
                                <input wire:model="kilowatts_to_provide" type="number" id="kilowatts_to_provide"
                                       name="kilowatts_to_provide"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('kilowatts_to_provide')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Columna Derecha -->
                        <div class="col-span-1">
                            <div class="mb-4">
                                <label for="name" class="text-lg font-semibold text-gray-600 py-2">Nombre</label>
                                <input wire:model="name" type="text" id="name" name="name"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="text-lg font-semibold text-gray-600 py-2">Descripción</label>
                                <textarea wire:model="description" id="description" name="description" rows="1"
                                          class="mt-1 p-2 block w-full border-gray-300 rounded-md"></textarea>
                                @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Columna derecha -->
                <div class="col-span-1 bg-white p-4 rounded-lg">
                    <!-- Título -->
                    <h2 class="text-center text-2xl font-bold mb-4">Recursos del Proyecto</h2>

                    <!-- Contenedor de información -->
                    <div class="p-4 rounded-lg">
                        <div class="flex justify-center space-x-4">
                            <div class="flex flex-col justify-center">
                                <button wire:click="showLaborForm"
                                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Mano de obra
                                </button>
                                <div class="text-teal-500 font-bold text-center ">{{ $totalLaborCost }}</div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <button wire:click="showMaterialsForm"
                                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Materiales
                                </button>
                                <div class="text-indigo-500 font-bold text-center ">{{ $totalMaterialCost }}</div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <button wire:click="showToolsForm"
                                        class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Herramientas
                                </button>
                                <div class="text-sky-500 font-bold text-center ">{{ $totalToolCost }}</div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <button wire:click="showTransportForm"
                                        class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Transporte
                                </button>
                                <div class="text-slate-500 font-bold text-center ">{{ $totalTransportCost }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <!-- Mostrar componente Livewire correspondiente -->
                        @if ($showResource === 'labor')
                            <livewire:projects.position-selection/>
                        @elseif ($showResource === 'materials')
                            <livewire:projects.material-selection/>
                        @elseif ($showResource === 'tools')
                            <livewire:projects.tool-selection/>
                        @elseif ($showResource === 'transport')
                            <livewire:projects.transport-selection/>
                        @endif
                    </div>
                </div>
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
                    wire:click="saveProject" wire:loading.attr="disabled" wire:target="saveProject">
                    Agregar
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

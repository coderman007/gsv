<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Nuevo APU </span>
    </button>

    <!-- Modal para crear un proyecto -->
    <x-dialog-modal maxWidth="7xl" wire:model.live="openCreate">
        <x-slot name="title">
            <h2 class="text-2xl font-semibold text-center text-gray-400 dark:text-white">Nuevo APU</h2>
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-5 bg-white p-4 rounded-lg">
                    <h2 class="text-center text-lg font-bold mb-4 text-blue-500">Datos</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1"><label for="project_category"
                                                       class="text-md font-semibold text-gray-600 py-2">Categoría</label>
                            <select wire:model.live="selectedCategory" id="project_category" name="project_category"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md text-sm">
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

                        <div class="col-span-1"><label for="zone"
                                                       class="text-md font-semibold text-gray-600 py-2">Zona</label>
                            <select wire:model.live="zone" id="zone" name="zone"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                <option value="">Seleccionar Zona</option>
                                @foreach ($zoneOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('zone')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="power_output" class="text-md font-semibold text-gray-600 py-2">Potencia
                                (kWp)
                            </label>
                            <input wire:model.live="power_output" type="number" id="power_output"
                                   name="power_output"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('power_output')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="required_area" class="text-md font-semibold text-gray-600 py-2">Área Mínima
                                Necesaria
                                (m²)</label>
                            <input wire:model.live="required_area" readonly id="required_area"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('required_area')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <!-- Campos para políticas comerciales -->
                    {{--<h3 class="text-center text-lg font-semibold text-blue-500 mb-4">Políticas Comerciales</h3>
                    <div class="grid grid-cols-2 gap-4">

                        <div class="col-span-1">
                            <label for="internalCommissions" class="text-md font-semibold text-gray-600 py-2">Comisiones Internas (%)</label>
                            <input wire:model="internalCommissions" readonly type="number" step="1" min="0" max="100"
                                   id="internalCommissions" name="internalCommissions"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('internalCommissions')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="externalCommissions" class="text-md font-semibold text-gray-600 py-2">Comisiones
                                Externas (%)</label>
                            <input wire:model="externalCommissions" readonly type="number" step="1" min="0" max="100"
                                   id="externalCommissions" name="externalCommissions"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('externalCommissions')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="margin" class="text-md font-semibold text-gray-600 py-2">Margen (%)</label>
                            <input wire:model="margin" readonly type="number" step="1" min="0" max="100" id="margin"
                                   name="margin"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('margin')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="discount" class="text-md font-semibold text-gray-600 py-2">Descuento (%)</label>
                            <input wire:model="discount" readonly type="number" step="1" min="0" max="100" id="discount"
                                   name="discount"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            @error('discount')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>--}}
                    <div class="flex bg-blue-100 w-full mt-10 px-4 py-2 items-center justify-between rounded-md">
                        <div class="text-blue-500 text-2xl">Costo de Venta</div>
                        <div class="text-center font-semibold text-lg flex items-center justify-center">
                            <!-- Icono de FontAwesome -->
                            <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500"></i> COP</span>

                            <!-- Texto que muestra el costo total -->
                            <span class="p-3 rounded-lg text-2xl font-bold">
                                ${{ number_format($totalProjectCost, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="col-span-7 bg-white p-4 rounded-lg">
                    <!-- Sección de recursos del proyecto -->
                    <h2 class="text-center text-lg font-bold mb-4 text-blue-500">Recursos</h2>

                    <div class="flex justify-center space-x-4">
                        <!-- Botones para recursos -->
                        <div class="flex flex-col justify-center">
                            <button wire:click="showLaborForm"
                                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full"
                                    type="button">Mano de obra
                            </button>
                            <div
                                class="text-teal-500 font-bold text-center ">{{ number_format($totalLaborCost, 2) }}</div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <button wire:click="showMaterialsForm"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full"
                                    type="button">Materiales
                            </button>
                            <div
                                class="text-indigo-500 font-bold text-center ">{{ number_format($totalMaterialCost, 2) }}</div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <button wire:click="showToolsForm"
                                    class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-full"
                                    type="button">Herramientas
                            </button>
                            <div
                                class="text-sky-500 font-bold text-center ">{{ number_format($totalToolCost, 2) }}</div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <button wire:click="showTransportForm"
                                    class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full"
                                    type="button">Transporte
                            </button>
                            <div
                                class="text-slate-500 font-bold text-center ">{{ number_format($totalTransportCost, 2) }}</div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <button wire:click="showAdditionalForm"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full"
                                    type="button">Adicionales
                            </button>
                            <div
                                class="text-yellow-500 font-bold text-center">{{ number_format($totalAdditionalCost, 2) }}</div>
                        </div>
                    </div>

                    <!-- Sección para formularios específicos -->
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
                        @elseif ($showResource === 'additionals')
                            <livewire:projects.additional-selection/>
                        @endif
                    </div>
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="mt-4 text-center flex justify-center space-x-2">
                <!-- Botón para cancelar/ cerrar el modal -->
                <x-button-exit wire:click="$set('openCreate', false)">
                    Cancelar
                </x-button-exit>

                <!-- Botón para agregar un nuevo proyecto -->
                <x-button-create wire:click="saveProject" wire:loading.attr="disabled" wire:target="saveProject">
                    Crear
                </x-button-create>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

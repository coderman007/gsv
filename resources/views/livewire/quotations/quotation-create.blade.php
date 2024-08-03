<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa-solid fa-file-circle-plus text-xl"></i> Nueva Cotización </span>
    </button>

    <!-- Modal para crear un proyecto -->
    <x-dialog-modal maxWidth="7xl" wire:model.live="openCreate">
        <x-slot name="title">
            <h2 class="text-2xl font-semibold text-center text-blue-400 dark:text-white">Nueva Cotización</h2>
        </x-slot>

        <x-slot name="content">
            <!-- Encabezado con Logo y Número de Cotización -->
            <div class="flex justify-between ">
                <!-- Logo de la Compañía -->
                {{--        <x-application-logo class="block h-12 w-auto"/>--}}
                <!-- Número de Cotización, Fecha y Periodo de Validez -->
                <div>
                    <div>
                        <p class="text-gray-600 font-semibold">Número de Cotización:</p>
                        <p class="text-lg text-blue-500 font-bold">{{ $consecutive }}</p>
                    </div>
                </div>
{{--                <div class="text-3xl font-bold text-center text-blue-500 uppercase">--}}
{{--                    COTIZACIÓN--}}
{{--                </div>--}}

                <!-- Fecha de Cotización y Validez -->
                <div class="flex flex-col justify-start mb-12">
                    <div>
                        <p class="text-gray-600 font-semibold">Fecha de Cotización:</p>
                        <p class="text-lg text-blue-500 font-bold">{{ \Carbon\Carbon::parse($quotation_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold">Validez (días):
                            <input type="number" min="1" max="365"
                                   class="w-16 h-8 mx-2 px-2 rounded text-lg text-blue-500 font-bold border-1 border-gray-500 bg-gray-200"
                                   wire:model="validity_period"/>
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <!-- Columna izquierda -->
                <div class="col-span-1">
                    <!-- Información del Cliente y radiación solar-->
                    <div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold" for="selectedClientId">Cliente</label>
                            <div class="flex space-x-2 mb-4">
                                <select id="selectedClientId"
                                        name="selectedClientId"
                                        wire:model="selectedClientId"
                                        wire:change="updateCityAndRadiation"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Seleccionar cliente...</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <livewire:quotations.quotation-client-create/>
                            </div>
                        </div>
                        @error('selectedClientId')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <div>
                            <label class="block text-gray-700 text-sm font-bold" for="solar_radiation_level">Nivel
                                de irradiancia</label>
                            <input type="number" id="solar_radiation_level" wire:model.live="solar_radiation_level"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   readonly>
                            @error('solar_radiation_level')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Costos Cotización -->
                    <div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold" for="total">Total</label>
                            <input type="number" id="total" wire:model="total"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('total')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="col-span-1">
                    <!-- Detalles de la Cotización -->
                    <div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="energy_to_provide">Energía a
                                    Generar (kWh-mes)</label>
                                <input type="number" id="energy_to_provide" wire:model.live="energy_to_provide"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('energy_to_provide')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="projectName">Potencia Sistema
                                    Seleccionado (kWp)</label>
                                <input type="text" id="projectName" wire:model="projectName"
                                       class="shadow appearance-none border rounded w-full py-2 px-2 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('projectName')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold"
                                       for="transformer">Transformador</label>
                                <select id="transformer" wire:model="transformer"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Seleccionar transformador...</option>
                                    <option value="Monofásico">Monofásico</option>
                                    <option value="Trifásico">Trifásico</option>
                                </select>
                                @error('transformer')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="transformerPower">Potencia del Transformador (kW)</label>
                                <input type="number" id="transformerPower" wire:model="transformerPower"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('transformerPower')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="panels_needed">Número de paneles requeridos</label>
                                <input type="number" id="panels_needed" wire:model="panels_needed"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                                @error('panels_needed')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="required_area">Área Necesaria (m²)</label>
                                <input type="number" id="required_area" wire:model="required_area"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                                @error('required_area')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold" for="kilowatt_cost">Costo por
                                    Kilowatt</label>
                                <input type="number" id="kilowatt_cost" wire:model="kilowatt_cost"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('kilowatt_cost')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Botón de Acción -->

                            <!-- Add more fields related to quotation details here -->
                        </div>
                    </div>
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
                        wire:click="createQuotation"
                        wire:loading.attr="disabled"
                        wire:target="createQuotation"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-regular fa-floppy-disk mr-2 text-xl"></i> Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

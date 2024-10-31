<div>
{{--    preguntar a Don Esteban si en el formulario de cotizaciones al estar registrado con un usuario que tenga el rol de vendedor se debe mostrar el listado de todos los clientes existentes en la base de datos o únicamente los clientes que estén Asociados a ese cliente en particular--}}
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-4 py-2 m-2 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-700 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-700 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa-solid fa-file-circle-plus text-xl"></i> Nueva Cotización </span>
    </button>

    <x-dialog-modal maxWidth="7xl" wire:model.live="openCreate">
        <x-slot name="title">
            <h2 class="text-2xl font-semibold text-center text-blue-700 dark:text-white">Nueva Cotización</h2>
            <!-- Encabezado con Logo y Número de Cotización -->
            <div class="flex justify-between ">
                <!-- Número de Cotización, Fecha y Periodo de Validez -->
                <div>
                    <p class="text-gray-600 font-semibold">Número de Cotización:</p>
                    <p class="text-lg text-blue-500 font-bold">{{ $consecutive }}</p>
                </div>

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
        </x-slot>

        <x-slot name="content">

            <!-- Mostrar el mensaje de error dinámico si existe -->
            @if ($errorMessage)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Error!</strong>
                    <span class="block sm:inline">{{ $errorMessage }}</span>
                </div>
            @endif

            @if ($project)
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">Se ha seleccionado un proyecto adecuado para la energía ingresada: {{ $projectName }}</span>
                </div>
            @endif


            <!-- Datos Requeridos -->
            <div class="bg-gray-100 p-4 rounded-md mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Datos Requeridos</h3>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="selectedClientId">Cliente</label>
                        <div class="flex space-x-2 mb-4">
                            <select id="selectedClientId"
                                    wire:model="selectedClientId"
                                    wire:change="updateCityAndRadiation"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Seleccionar cliente...</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedClientId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <livewire:quotations.quotation-client-create/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="solar_radiation_level">Nivel de
                            irradiancia</label>
                        <input type="number" id="solar_radiation_level" wire:model.live="solar_radiation_level"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               readonly>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="energy_client">Energía a Generar
                            (kWh-mes)</label>
                        <input type="number" id="energy_client" wire:model.live="energy_client"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="kilowatt_cost">Costo por
                            Kilowatt</label>
                        <input type="number" id="kilowatt_cost" wire:model="kilowatt_cost"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="transformer">Transformador</label>
                        <select id="transformer" wire:model="transformer"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Seleccionar transformador...</option>
                            <option value="Monofásico">Monofásico</option>
                            <option value="Trifásico">Trifásico</option>
                        </select>
                        @error('transformerPower')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="transformerPower">Potencia del
                            Transformador (kW)</label>
                        <input type="number" id="transformerPower" wire:model="transformerPower"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <!-- Datos Calculados -->
            <div class="bg-gray-200 p-4 rounded-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Resumen de la Cotización</h3>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="panels_needed">Número de paneles
                            requeridos</label>
                        <input type="number" id="panels_needed" wire:model="panels_needed"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               readonly>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="required_area">Área Necesaria
                            (m²)</label>
                        <input type="number" id="required_area" wire:model="required_area"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               readonly>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="projectName">Potencia Sistema
                            Seleccionado (kWp)</label>
                        <input type="text" id="projectName" wire:model="projectName"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               readonly>
                    </div>

                    <div>
                        <label class="block text-green-700 text-sm font-bold" for="total">Total</label>
                        <input type="text" id="total" value="{{ $this->totalFormatted }}"
                               class="shadow appearance-none rounded w-full py-2 px-3 bg-green-100 text-green-700 leading-tight border border-green-500 focus:outline-none focus:shadow-outline focus:ring-green-500"
                               readonly>
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
                        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                    <i class="fa-regular fa-floppy-disk mr-2 text-xl"></i> Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

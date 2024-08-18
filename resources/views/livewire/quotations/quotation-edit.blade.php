<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal maxWidth="7xl" wire:model.live="openEdit">
        <x-slot name="title">
            <h2 class="text-2xl font-semibold text-center text-blue-700 dark:text-white">Editar Cotización</h2>
            <!-- Encabezado con Logo y Número de Cotización -->
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-600 font-semibold">Número de Cotización:</p>
                    <p class="text-lg text-blue-500 font-bold">{{ $consecutive }}</p>
                </div>
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
            <!-- Datos Requeridos -->
            <div class="bg-gray-100 p-4 rounded-md mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Datos Requeridos</h3>
                <div class="grid grid-cols-2 gap-8">
                    <!-- Selección de Cliente -->
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
                        </div>
                    </div>

                    <!-- Energía a Proporcionar -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="energy_to_provide">Energía a
                            Proporcionar (kWh/mes)</label>
                        <div class="flex space-x-2 mb-4">
                            <input id="energy_to_provide" type="number" min="0"
                                   wire:model="energy_to_provide"
                                   wire:input="updatedEnergyToProvide"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Ciudad -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Ciudad</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="text" value="{{ $city }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Nivel de Radiación Solar -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Nivel de Radiación Solar</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="text" value="{{ $solar_radiation_level }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Selección de Transformador -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Transformador</label>
                        <div class="flex space-x-2 mb-4">
                            <select wire:model="transformer"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Trifásico">Trifásico</option>
                                <option value="Monofásico">Monofásico</option>
                            </select>
                        </div>
                    </div>

                    <!-- Potencia del Transformador -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="transformerPower">Potencia del
                            Transformador (kW)</label>
                        <div class="flex space-x-2 mb-4">
                            <input id="transformerPower" type="number" min="0"
                                   wire:model="transformerPower"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Área Requerida -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="required_area">Área Requerida
                            (m²)</label>
                        <div class="flex space-x-2 mb-4">
                            <input id="required_area" type="number" min="0"
                                   wire:model="required_area"
                                   readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Costo por Kilovatio -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold" for="kilowatt_cost">Costo por
                            Kilovatio ($/kW)</label>
                        <div class="flex space-x-2 mb-4">
                            <input id="kilowatt_cost" type="number" min="0"
                                   wire:model="kilowatt_cost"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de la Cotización -->
            <div class="bg-white p-4 rounded-md mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Resumen de la Cotización</h3>
                <div class="grid grid-cols-2 gap-8">
                    <!-- Proyecto Seleccionado -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Proyecto Seleccionado</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="text" value="{{ $projectName }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Paneles Requeridos -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Paneles Requeridos</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="number" value="{{ $panels_needed }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Subtotal ($)</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="number" value="{{ $subtotal }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <!-- Total -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold">Total ($)</label>
                        <div class="flex space-x-2 mb-4">
                            <input type="number" value="{{ $total }}" readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mt-4 text-center flex justify-center space-x-2">
                <!-- Botón para cancelar/ cerrar el modal -->
                <x-button-exit wire:click="$set('openEdit', false)">
                    Cancelar
                </x-button-exit>

                <!-- Botón para guardar cambios en el proyecto -->
                <x-button-edit wire:click="updateQuotation" wire:loading.attr="disabled" wire:target="updateQuotation">
                    Actualizar
                </x-button-edit>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

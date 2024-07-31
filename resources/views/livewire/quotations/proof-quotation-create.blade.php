{{--<div>--}}
{{--    <button wire:click="$set('openCreate', true)"--}}
{{--            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">--}}
{{--        <span--}}
{{--            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>--}}
{{--        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">--}}
{{--            <i class="fa-solid fa-file-circle-plus text-xl"></i> Nueva Cotización </span>--}}
{{--    </button>--}}

{{--    <!-- Modal para crear un proyecto -->--}}
{{--    <x-dialog-modal maxWidth="7xl" wire:model.live="openCreate">--}}
{{--        <x-slot name="title">--}}
{{--            <h2 class="text-2xl font-semibold text-center text-blue-400 dark:text-white">Nueva Cotización</h2>--}}
{{--        </x-slot>--}}

{{--        <x-slot name="content">--}}
{{--            <!-- Encabezado con Logo y Número de Cotización -->--}}
{{--            <div class="flex justify-between ">--}}
{{--                <!-- Logo de la Compañía -->--}}
{{--                --}}{{--        <x-application-logo class="block h-12 w-auto"/>--}}
{{--                <!-- Número de Cotización, Fecha y Periodo de Validez -->--}}
{{--                <div>--}}
{{--                    <div class="">--}}
{{--                        <p class="text-gray-600 font-semibold">Número de Cotización:</p>--}}
{{--                        <p class="text-lg text-blue-500 font-bold">{{ $consecutive }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="text-3xl font-bold text-center text-blue-500 uppercase">--}}
{{--                    COTIZACIÓN--}}
{{--                </div>--}}

{{--                <!-- Fecha de Cotización y Validez -->--}}
{{--                <div class="flex flex-col justify-start mb-12">--}}
{{--                    <div class="">--}}
{{--                        <p class="text-gray-600 font-semibold">Fecha de Cotización:</p>--}}
{{--                        <p class="text-lg text-blue-500 font-bold">{{ \Carbon\Carbon::parse($quotation_date)->format('d/m/Y') }}</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p class="text-gray-600 font-semibold">Validez (días):--}}
{{--                            <input type="number" min="1" max="365"--}}
{{--                                   class="w-16 h-8 mx-2 px-2 rounded text-lg text-blue-500 font-bold border-1 border-gray-500 bg-gray-200"--}}
{{--                                   wire:model="validity_period"/>--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="grid grid-cols-2 gap-8">--}}
{{--                <!-- Columna izquierda -->--}}
{{--                <div class="col-span-1">--}}
{{--                    <!-- Información del Cliente -->--}}
{{--                    <div>--}}
{{--                        <div>--}}
{{--                            <label class="block text-gray-700 text-sm font-bold" for="selectedClientId">Cliente</label>--}}
{{--                            <div class="flex space-x-2 mb-4">--}}
{{--                                <select id="selectedClientId"--}}
{{--                                        name="selectedClientId"--}}
{{--                                        wire:model="selectedClientId"--}}
{{--                                        wire:change="updateCityAndRadiation"--}}
{{--                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                    <option value="">Seleccionar cliente...</option>--}}
{{--                                    @foreach ($clients as $client)--}}
{{--                                        <option value="{{ $client->id }}">{{ $client->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                <livewire:quotations.quotation-client-create/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @error('selectedClientId')--}}
{{--                        <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <!-- Costos Cotización -->--}}
{{--                    <div class="">--}}
{{--                        <div>--}}
{{--                            <div class="mb-4">--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="subtotal">Subtotal</label>--}}
{{--                                <input type="number" id="subtotal" wire:model="subtotal"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('subtotal')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="total">Total</label>--}}
{{--                                <input type="number" id="total" wire:model="total"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('total')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Columna derecha -->--}}
{{--                <div class="col-span-1">--}}
{{--                    <!-- Detalles de la Cotización -->--}}
{{--                    <div>--}}
{{--                        <div class="grid grid-cols-2 gap-4">--}}
{{--                            <div>--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="energy_to_provide">Energía a Generar (kWh)</label>--}}
{{--                                <input type="number" id="energy_to_provide" wire:model.live="energy_to_provide"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('energy_to_provide')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div class="">--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="projectName">APU--}}
{{--                                    Apropiado</label>--}}
{{--                                <input type="text" id="projectName" wire:model="projectName"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-2 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('projectName')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div>--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="solar_radiation_level">Nivel de irradiancia</label>--}}
{{--                                <input type="number" id="solar_radiation_level" wire:model.live="solar_radiation_level"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>--}}
{{--                                @error('solar_radiation_level')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div class="">--}}
{{--                                <label class="block text-gray-700 text-sm font-bold"--}}
{{--                                       for="transformer">Transformador</label>--}}
{{--                                <select id="transformer" wire:model="transformer"--}}
{{--                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                    <option value="">Seleccionar transformador...</option>--}}
{{--                                    <option value="Monofásico">Monofásico</option>--}}
{{--                                    <option value="Trifásico">Trifásico</option>--}}
{{--                                </select>--}}
{{--                                @error('transformer')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="">--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="kilowatt_cost">Costo por--}}
{{--                                    Kilowatt</label>--}}
{{--                                <input type="number" id="kilowatt_cost" wire:model="kilowatt_cost"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('kilowatt_cost')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="">--}}
{{--                                <label class="block text-gray-700 text-sm font-bold" for="roof_dimension">Dimensión--}}
{{--                                    Cubierta--}}
{{--                                    (m²)</label>--}}
{{--                                <input type="number" id="roof_dimension" wire:model="roof_dimension"--}}
{{--                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                                @error('roof_dimension')--}}
{{--                                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <!-- Botón de Acción -->--}}

{{--                            <!-- Add more fields related to quotation details here -->--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </x-slot>--}}

{{--        <x-slot name="footer">--}}
{{--            <div class="flex justify-end mt-6">--}}
{{--                <x-info-button wire:click="createQuotation">Cotizar--}}
{{--                </x-info-button>--}}

{{--            </div>--}}
{{--        </x-slot>--}}
{{--    </x-dialog-modal>--}}
{{--</div>--}}

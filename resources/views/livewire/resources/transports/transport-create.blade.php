<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa fa-solid fa-plus text-xl"></i> Agregar
        </span>
    </button>

    <x-dialog-modal wire:model="openCreate">
        <div class="flex h-screen bg-gray-200">
            <div class="m-auto">
                <div class="w-1">
                    <x-slot name="title"></x-slot>
                    <x-slot name="content">
                        <div>
                            <div
                                class="relative w-full flex justify-center items-center p-5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none transition duration-500 transform active:scale-95 ease-in-out">
                                <span class="pl-2 mx-1">
                                    <h2 class="mt-3 text-2xl text-center">Crear Transporte</h2>
                                </span>
                            </div>
                            <div class="mt-5 bg-white rounded-lg shadow">
                                <!-- Tipo de Vehículo -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Tipo de Vehículo" />
                                    <input wire:model="vehicle_type" placeholder="Tipo de Vehículo"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="vehicle_type" />
                                </div>
                                <!-- Millas Anuales -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Millas Anuales" />
                                    <input wire:model="annual_mileage" type="number" placeholder="Millas Anuales"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="annual_mileage" />
                                </div>
                                <!-- Velocidad Promedio -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Velocidad Promedio" />
                                    <input wire:model="average_speed" type="number" placeholder="Velocidad Promedio"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="average_speed" />
                                </div>
                                <!-- Valor Comercial -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Valor Comercial" />
                                    <input wire:model="commercial_value" type="number" placeholder="Valor Comercial"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="commercial_value" />
                                </div>
                                <!-- Tasa de Depreciación -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Tasa de Depreciación" />
                                    <input wire:model="depreciation_rate" type="number"
                                        placeholder="Tasa de Depreciación"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="depreciation_rate" />
                                </div>
                                <!-- Costo Mantenimiento Anual -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700"
                                        value="Costo Mantenimiento Anual" />
                                    <input wire:model="annual_maintenance_cost" type="number"
                                        placeholder="Costo Mantenimiento Anual"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="annual_maintenance_cost" />
                                </div>
                                <!-- Costo por Km Convencional -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700"
                                        value="Costo por Km Convencional" />
                                    <input wire:model="cost_per_km_conventional" type="number"
                                        placeholder="Costo por Km Convencional"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="cost_per_km_conventional" />
                                </div>
                                <!-- Costo por Km con Combustible -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700"
                                        value="Costo por Km con Combustible" />
                                    <input wire:model="cost_per_km_fuel" type="number"
                                        placeholder="Costo por Km con Combustible"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="cost_per_km_fuel" />
                                </div>
                                <!-- Salario Mensual -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Salario Mensual" />
                                    <input wire:model="salary_per_month" type="number" placeholder="Salario Mensual"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="salary_per_month" />
                                </div>
                                <!-- Salario por Hora -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Salario por Hora" />
                                    <input wire:model="salary_per_hour" type="number" placeholder="Salario por Hora"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="salary_per_hour" />
                                </div>
                            </div>
                        </div>
                    </x-slot>
                    <hr class="mt-4">
                    <x-slot name="footer">
                        <div class="mx-auto">
                            <div class="flex gap-16">
                                <button type="button" wire:click="$toggle('openCreate')"
                                    class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition duration-300 transform active:scale-95 ease-in-out">
                                    <span class="mx-1">
                                        <svg class="w-5 h-5 mr-2 font-extrabold " fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12">
                                            </path>
                                        </svg>
                                    </span>
                                    Salir
                                </button>
                                <button type="button"
                                    class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-blue-500 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                                    wire:click="createTransport" wire:loading.attr="disabled"
                                    wire:target="createTransport">
                                    <span class="mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 640 512"
                                            width="24px" fill="#FFFFFF">
                                            <path
                                                d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                        </svg>
                                    </span>
                                    Crear
                                </button>
                            </div>
                        </div>
                    </x-slot>
                </div>
            </div>
        </div>
    </x-dialog-modal>
</div>
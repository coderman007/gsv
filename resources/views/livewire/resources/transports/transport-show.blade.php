<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>

        <x-dialog-modal wire:model="openShow">
            <x-slot name="title">
                <!-- Puedes agregar un título aquí si es necesario -->
            </x-slot>

            <x-slot name="content">
                <div class="md:px-5 pb-5">
                    <div class="md:mx-6">
                        <div class="bg-gray-500 p-4 rounded-lg text-white text-center">
                            <!-- Mostrar detalles del recurso de transporte -->
                            <h3 class="text-xl font-semibold">{{ $transport->vehicle_type }}</h3>
                            <p class="p-2 rounded-md text-lg text-center">
                                Millaje Anual: {{ $transport->annual_mileage }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Velocidad Promedio: {{ $transport->average_speed }} km/h
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Valor Comercial: ${{ $transport->commercial_value }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Tasa de Depreciación: {{ $transport->depreciation_rate }}%
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Costo de Mantenimiento Anual: ${{ $transport->annual_maintenance_cost }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Costo por km (Convencional): ${{ $transport->cost_per_km_conventional }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Costo por km (Combustible): ${{ $transport->cost_per_km_fuel }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Salario Mensual: ${{ $transport->salary_per_month }}
                            </p>
                            <p class="p-2 rounded-md text-lg text-center">
                                Salario por Hora: ${{ $transport->salary_per_hour }}
                            </p>
                            <!-- Agrega más detalles según sea necesario -->
                        </div>

                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <a href="#_" wire:click="$set('openShow', false)"
                        class="box-border relative z-30 inline-flex items-center justify-center w-auto px-8 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-red-600 rounded-md cursor-pointer group ring-offset-2 ring-1 ring-red-200 ring-offset-red-100 hover:ring-offset-red-500 ease focus:outline-none">
                        <span
                            class="absolute bottom-0 right-0 w-8 h-20 -mb-8 -mr-5 transition-all duration-300 ease-out transform rotate-45 translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
                        <span
                            class="absolute top-0 left-0 w-20 h-8 -mt-1 -ml-12 transition-all duration-300 ease-out transform -rotate-45 -translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
                        <span class="relative z-20 flex items-center text-md">
                            <svg class="w-5 h-5 mr-2 font-extrabold " fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Salir
                        </span>
                    </a>
                </div>
            </x-slot>
        </x-dialog-modal>
    </div>


<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openShow">
        <x-slot name="title">
            <h2 class="text-2xl font-bold text-blue-600">Detalles de la Cotización</h2>
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full bg-gray-100">
                <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <!-- Información General -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Información General</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Número de Cotización:</dt>
                                    <dd class="highlight">{{ $quotation->consecutive }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Fecha de Emisión:</dt>
                                    <dd class="highlight">{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Período de Validez:</dt>
                                    <dd class="highlight">{{ $quotation->validity_period }} días</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Cliente:</dt>
                                    <dd class="highlight">{{ $quotation->client->name }}</dd>
                                </div>

                            </dl>
                        </div>

                        <!-- Detalles del Sistema -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Detalles del Sistema</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Energía a Proveer:</dt>
                                    <dd class="highlight">{{ $quotation->energy_to_provide }} kWh</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Nivel de Radiación Solar:</dt>
                                    <dd class="highlight">{{ $quotation->client->city->irradiance }} kWh/m²/día</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Transformador:</dt>
                                    <dd class="highlight">{{ $quotation->transformer }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Potencia del Transformador:</dt>
                                    <dd class="highlight">{{ $quotation->transformer_power }} kW</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Área Requerida:</dt>
                                    <dd class="highlight">{{ $quotation->required_area }} m²</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Número de Paneles Necesarios:</dt>
                                    <dd class="highlight">{{ $quotation->panels_needed }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Costos -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Costos</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Costo por Kilovatio:</dt>
                                    <dd class="highlight">${{ number_format($quotation->kilowatt_cost, 2) }}</dd>
                                </div>
{{--                                <div class="flex justify-between">--}}
{{--                                    <dt class="font-medium text-gray-600">Valor Bruto:</dt>--}}
{{--                                    <dd class="highlight">${{ number_format($quotation->subtotal, 2) }}</dd>--}}
{{--                                </div>--}}
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-600">Total:</dt>
                                    <dd class="highlight">${{ number_format($quotation->total, 2) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end p-4">
                <button wire:click="$set('openShow', false)"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold py-2 px-4 rounded-md">
                    Salir
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

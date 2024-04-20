<div class=" m-4 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Columna izquierda: Formulario de cotización -->
    <div class="bg-white shadow shadow-gray-500 overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium text-center leading-6 text-gray-900">Formulario Cotización</h3>
        </div>
        <form wire:submit="createQuotation">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Fecha de la Cotización -->
                    <div>
                        <label for="quotation_date" class="block text-sm font-medium text-gray-700">Fecha de la
                            Cotización</label>
                        <input type="date" id="quotation_date" name="quotation_date"
                               wire:model="quotation_date"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Período de validez -->
                    <div>
                        <label for="validity_period" class="block text-sm font-medium text-gray-700">Período de
                            Validez (en días)</label>
                        <input type="number" id="validity_period" name="validity_period"
                               wire:model="validity_period"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Potencia del transformador -->
                    <div>
                        <label for="transformer" class="block text-sm font-medium text-gray-700">Potencia del
                            Transformador</label>
                        <input type="text" id="transformer" name="transformer" wire:model="transformer"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Costo total por kilovatio -->
                    <div>
                        <label for="total_cost_kilowatt" class="block text-sm font-medium text-gray-700">Costo
                            Total por Kilovatio</label>
                        <input type="number" id="total_cost_kilowatt" name="total_cost_kilowatt"
                               wire:model="total_cost_kilowatt"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Comisiones Internas -->
                    <div>
                        <label for="internal_commissions" class="block text-sm font-medium text-gray-700">Comisiones
                            Internas</label>
                        <input type="number" id="internal_commissions" name="internal_commissions"
                               wire:model="internal_commissions"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Comisiones Externas -->
                    <div>
                        <label for="external_commissions" class="block text-sm font-medium text-gray-700">Comisiones
                            Externas</label>
                        <input type="number" id="external_commissions" name="external_commissions"
                               wire:model="external_commissions"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>

                    <!-- Subtotal -->
                    <div>
                        <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal</label>
                        <input type="number" id="subtotal" name="subtotal"
                               wire:model="subtotal"
                               class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    </div>
                </div>
            </div>
            <div class="px-4 py-4 sm:px-6">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Crear Cotización
                </button>
            </div>
        </form>
    </div>

    <!-- Columna derecha: Detalles del proyecto -->
    <div class="bg-white h-auto shadow shadow-gray-500 overflow-hidden sm:rounded-lg">
        <div>
            {{--Datos del cliente--}}
            <div class="m-4">
                <label for="selectedClientId" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select id="selectedClientId" name="selectedClientId" wire:model="selectedClientId"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="" disabled selected>Seleccionar cliente...</option>
                    @foreach ($this->clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <livewire:quotations.quotation-client-create/>
            </div>
            <!-- Promedio de energía -->
            <div class="m-4">
                <label for="average_energy_consumption" class="block text-sm font-medium text-gray-700">Promedio de
                    energía del cliente (kWh)</label>
                <input type="number" id="average_energy_consumption" name="average_energy_consumption"
                       wire:model.live="average_energy_consumption"
                       class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
        </div>
        @if ($this->project)
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        @if ($this->project->id)
                            <!-- Detalles del Proyecto -->
                            <div wire:model="project.name"
                                 class="bg-slate-100 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @if ($this->project->id)
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-700">Detalles del Proyecto:</p>
                                        <ul class="mt-1 grid grid-cols-2 gap-4">
                                            <li><span class="text-sm font-medium text-gray-700">Nombre:</span>
                                                <span class="text-sm text-gray-500">{{ $project->name }}</span>
                                            </li>
                                            <li><span class="text-sm font-medium text-gray-700">Descripción:</span>
                                                <span class="text-sm text-gray-500">{{ $project->description }}</span>
                                            </li>
                                            <li><span class="text-sm font-medium text-gray-700">Costo total de mano de obra:</span>
                                                <span class="text-sm text-gray-500">${{ $project->totalLaborCost() }}</span>
                                            </li>
                                            <li><span class="text-sm font-medium text-gray-700">Costo total de materiales:</span>
                                                <span class="text-sm text-gray-500">${{ $project->totalMaterialCost() }}</span>
                                            </li>
                                            <li><span class="text-sm font-medium text-gray-700">Costo total de herramientas:</span>
                                                <span class="text-sm text-gray-500">${{ $project->totalToolCost() }}</span>
                                            </li>
                                            <li><span class="text-sm font-medium text-gray-700">Costo total de transporte:</span>
                                                <span class="text-sm text-gray-500">${{ $project->totalTransportCost() }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

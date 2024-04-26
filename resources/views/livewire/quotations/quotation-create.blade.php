<div class="p-10 m-10 bg-white rounded-lg shadow-lg flex">
    <!-- Columna izquierda: Formulario de cotización -->
    <div class="w-1/2 pr-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Formulario de Cotización</h3>

        <form wire:submit="createQuotation">
            <!-- Selección de cliente -->
            <div class="mb-6">
                <label for="selectedClientId" class="block font-semibold mb-2">Cliente</label>
                <div class="relative flex items-center justify-between">
                    <select
                        id="selectedClientId"
                        name="selectedClientId"
                        wire:model="selectedClientId"
                        class="w-2/3 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                        <option value="">Seleccionar cliente...</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    <livewire:quotations.quotation-client-create/>
                    @error('selectedClientId')
                    <span class="absolute bottom-0 left-0 text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Detalles del proyecto -->
            <div class="border border-gray-300 rounded-md p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="average_energy_consumption" class="block font-semibold mb-2">Consumo promedio de
                            energía (kWh)</label>
                        <input
                            type="number"
                            id="average_energy_consumption"
                            wire:model.live="average_energy_consumption"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('average_energy_consumption')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="solar_radiation_level" class="block font-semibold mb-2">Nivel de irradiación
                            solar</label>
                        <input
                            type="number"
                            id="solar_radiation_level"
                            wire:model="solar_radiation_level"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('solar_radiation_level')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label para="roof_dimension" class="block font-semibold mb-2">Dimensión del techo (m²)</label>
                    <input
                        type="number"
                        id="roof_dimension"
                        wire:model="roof_dimension"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                    @error('roof_dimension')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Otros detalles de la cotización -->
            <div class="border border-gray-300 rounded-md p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label para="internal_commissions" class="block font-semibold mb-2">Comisiones internas</label>
                        <input
                            type="number"
                            id="internal_commissions"
                            wire:model="internal_commissions"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('internal_commissions')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label para="external_commissions" class="block font-semibold mb-2">Comisiones externas</label>
                        <input
                            type="number"
                            id="external_commissions"
                            wire:model="external_commissions"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('external_commissions')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label para="quotation_date" class="block font-semibold mb-2">Fecha de cotización</label>
                        <input
                            type="date"
                            id="quotation_date"
                            wire:model="quotation_date"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('quotation_date')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md-grid-cols-2 gap-4">
                    <div>
                        <label para="validity_period" class="block font-semibold mb-2">Período de validez (días)</label>
                        <input
                            type="number"
                            id="validity_period"
                            wire:model="validity_period"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('validity_period')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label para="margin" class="block font-semibold mb-2">Margen (opcional)</label>
                        <input
                            type="number"
                            id="margin"
                            wire:model="margin"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @error('margin')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Columna derecha: Detalles del Proyecto -->
    <div class="w-1/2 pl-6">
        @if ($this->project)
            <div class="p-6 bg-gray-100 border rounded-lg shadow-sm">
                <h4 class="text-2xl font-semibold text-center text-gray-800 mb-4">Detalles del Proyecto</h4>

                <div class="flex flex-col space-y-4">
                    <!-- Nombre del proyecto -->
                    <div class="flex items-center justify-center">
                        <div class="flex items-center space-x-6">
                        </div>
                        <span>{{ $project->name }}</span>
                    </div>

                    <!-- Total de mano de obra -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-people-carry text-emerald-500"></i>
                            <span class="font-semibold ml-4">Total de mano de obra:</span>
                        </div>
                        <span class="text-emerald-500">${{ $project->totalLaborCost() }}</span>
                    </div>

                    <!-- Total de materiales -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <i class="fas fa-box text-indigo-500"></i>
                            <span class="font-semibold ml-4">Total de materiales:</span>
                        </div>
                        <span class="text-indigo-500">${{ $project->totalMaterialCost() }}</span>
                    </div>

                    <!-- Total de herramientas -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <i class="fas fa-tools text-sky-500"></i>
                            <span class="font-semibold ml-4">Total de herramientas:</span>
                        </div>
                        <span class="text-sky-500">${{ $project->totalToolCost() }}</span>
                    </div>

                    <!-- Total de transporte -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-truck text-gray-600"></i>
                            <span class="font-semibold ml-4">Total de transporte:</span>
                        </div>
                        <span class="text-gray-600">${{ $project->totalTransportCost() }}</span>
                    </div>
                </div>
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center h-full p-6 text-gray-600 text-center bg-gray-100 border rounded-lg shadow-sm">
                <i class="fas fa-exclamation-circle text-4xl text-gray-400 mb-4"></i>
                <p>No hay información del proyecto para mostrar.</p>
            </div>
        @endif
    </div>
</div>

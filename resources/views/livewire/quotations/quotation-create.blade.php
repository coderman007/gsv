<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mt-8">
        <!-- Encabezado -->
        <h2 class="text-2xl font-semibold text-gray-900">Crear Cotización</h2>

        <!-- Cliente -->
        <div class="mt-6">
            <label for="selectedClientId" class="block text-sm font-medium text-gray-700">Cliente</label>
            <select id="selectedClientId" name="selectedClientId" wire:model="selectedClientId"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Seleccionar cliente...</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            <livewire:quotations.quotation-client-create />

        </div>

        <!-- Promedio de energía y tipo de proyecto -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Promedio de energía -->
            <div>
                <label for="average_energy_consumption" class="block text-sm font-medium text-gray-700">Promedio de
                    energía del cliente (kWh)</label>
                <input type="number" id="average_energy_consumption" name="average_energy_consumption"
                    wire:model="average_energy_consumption"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>

            <!-- Tipo de Proyecto -->
            <div>
                <label for="project" class="block text-sm font-medium text-gray-700">Tipo de Proyecto</label>
                <input type="text" id="project" name="project" readonly wire:model="project.name"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <!-- Costos totales -->
                <div class="mt-2">
                    <p class="text-sm font-medium text-gray-700">Costos Totales:</p>
                    <ul class="mt-1 grid grid-cols-2 gap-4">
                        <li><span class="text-sm font-medium text-gray-700">Mano de Obra:</span> <span
                                class="text-sm text-gray-500">${{ $totalLaborCost }}</span></li>
                        <li><span class="text-sm font-medium text-gray-700">Materiales:</span> <span
                                class="text-sm text-gray-500">${{ $totalMaterialCost }}</span></li>
                        <li><span class="text-sm font-medium text-gray-700">Herramientas:</span> <span
                                class="text-sm text-gray-500">${{ $totalToolCost }}</span></li>
                        <li><span class="text-sm font-medium text-gray-700">Transporte:</span> <span
                                class="text-sm text-gray-500">${{ $totalTransportCost }}</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Resto de datos de la cotización -->
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Resto de los campos para la creación de la cotización -->
            <!-- ... -->

            <!-- Botón para crear la cotización -->
            <div class="mt-6">
                <button wire:click="createQuotation"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Crear Cotización
                </button>
            </div>

            <!-- Mostrar mensajes de éxito o error -->
            @if (session()->has('message'))
                <div class="text-green-500">{{ session('message') }}</div>
            @endif
        </div>
    </div>
</div>

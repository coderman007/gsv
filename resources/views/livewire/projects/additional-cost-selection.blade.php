<div class="flex flex-col w-full">
    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                class="appearance-none block w-full px-3 py-2 border-2 border-yellow-500 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                placeholder="Buscar adicionales...">
        </div>
    </div>

    <ul class="overflow-y-auto max-h-96">
        @forelse ($additionalCosts as $additionalCost)
            <li class="flex items-center py-2 hover:bg-gray-100">
                <input type="checkbox" wire:model.live="selectedAdditionalCosts" value="{{ $additionalCost->id }}"
                    class="mr-2 border-yellow-300 rounded shadow-sm text-yellow-500 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                <div class="w-full flex justify-between items-center">
                    <div>
                        <span class="text-gray-800 font-medium">{{ $additionalCost->name }} </span>

                    </div>
                    @if (in_array($additionalCost->id, $selectedAdditionalCosts))
                        <div class="flex items-center">
                            <div class="flex flex-col mr-4">
                                <label for="quantity_{{ $additionalCost->id }}"
                                    class="text-sm text-gray-700 mb-1">Cantidad:</label>
                                <input wire:model.live="quantities.{{ $additionalCost->id }}"
                                    id="quantity_{{ $additionalCost->id }}" type="number"
                                    class="w-20 px-2 py-1 border border-yellow-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="cost_{{ $additionalCost->id }}" class="text-sm text-gray-700 mb-1">Costo:</label>
                                <input id="cost_{{ $additionalCost->id }}" type="text"
                                    value="{{ $additionalCost->amount * ($quantities[$additionalCost->id] ?? 0) }}"
                                    class="w-28 px-2 py-1 border border-yellow-300 rounded-md bg-gray-100 focus:outline-none">
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">No se encontraron costos adicionales.</li>
        @endforelse
    </ul>


    <div class="bg-gray-50 p-2 rounded-lg mb-4 flex items-center">
        <label for="totalAdditionalCost" class="block text-lg mr-4 font-medium text-gray-700">Total Costos Adicionales</label>
        <div class="relative rounded-md shadow-sm flex-1">
            <input type="text" readonly wire:model.live="formattedTotalAdditionalCost" id="totalAdditionalCost"
                class="text-right mt-1 p-2 pl-10 block w-full border-yellow-500 rounded-md bg-yellow-100 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP</span>
            </div>
        </div>

        <div class="ml-4">
            <button wire:click="sendTotalAdditionalCost" type="button"
                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">
                Enviar
            </button>
        </div>
    </div>
</div>

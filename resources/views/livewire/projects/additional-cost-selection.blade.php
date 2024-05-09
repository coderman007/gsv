<div class="flex flex-col w-full">
    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                   class="appearance-none block w-full px-3 py-2 border-2 border-yellow-500 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                   placeholder="Buscar costos adicionales...">
        </div>
    </div>

    <ul class="overflow-y-auto max-h-96">
        @forelse ($additionalCosts as $cost)
            <li class="flex items-center py-2 hover:bg-gray-100">
                <input type="checkbox" wire:model.live="selectedAdditionalCosts" value="{{ $cost->id }}"
                       class="mr-2 border-yellow-300 rounded shadow-sm text-yellow-500 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                <div class="w-full flex justify-between items-center">
                    <div>
                        <span class="text-gray-800 font-medium">{{ $cost->name }}</span>
                    </div>

                    @if (in_array($cost->id, $selectedAdditionalCosts))
                        <div class="flex items-center space-x-4 pr-4">
                            <!-- Cantidad -->
                            <div class="flex flex-col">
                                <label for="quantity_{{ $cost->id }}"
                                       class="text-sm text-gray-700 mb-1">Cantidad:</label>
                                <input wire:model.live="quantities.{{ $cost->id }}"
                                       id="quantity_{{ $cost->id }}" min=1 type="number"
                                       class="w-16 px-2 py-1 border border-yellow-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            </div>

                            <!-- Rendimiento -->
                            <div class="flex flex-col">
                                <label for="efficiency_{{ $cost->id }}" class="text-sm text-gray-700 mb-1">Rendimiento:</label>
                                <input wire:model.live="efficiencies.{{ $cost->id }}"
                                       id="efficiency_{{ $cost->id }}" type="text"
                                       class="w-16 px-2 py-1 border border-yellow-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            </div>

                            <!-- Costo parcial-->
                            <div class="flex flex-col">
                                <label for="cost_{{ $cost->id }}" class="text-sm text-gray-700 mb-1">Costo parcial:</label>
                                <input type="text" readonly
                                       value="{{ isset($partialCosts[$cost->id]) ? number_format($partialCosts[$cost->id], 2) : 0 }}"
                                       class="w-32 px-2 py-1 border border-yellow-300 rounded-md focus:outline-none">
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">No se encontraron costos adicionales.</li>
        @endforelse
    </ul>

    <!-- Costo total -->
    <div class="bg-gray-50 p-2 rounded-lg mb-4 flex items-center">
        <label for="totalCost" class="block text-lg mr-4 font-medium text-gray-700">Costo total</label>
        <div class="relative rounded-md shadow-sm flex-1">
            <input type="text" readonly wire:model.live="formattedTotalCost"
                   class="text-right mt-1 p-2 block w-full border-yellow-500 rounded-md bg-yellow-100 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <span class="text-gray-500 sm:text-sm">
                    <i class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP
                </span>
            </div>
        </div>

        <div class="ml-4">
            <button wire:click="sendTotalCost" type="button"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">
                Enviar
            </button>
        </div>
    </div>
</div>

<div class="flex flex-col w-full">
    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                   class="appearance-none block w-full px-3 py-2 border-2 border-indigo-500 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Buscar materiales...">
        </div>
    </div>

    <!-- Lista de materiales -->
    <ul class="overflow-y-auto max-h-96">
        @forelse ($materials as $material)
            <li class="flex items-center py-2 hover:bg-gray-100">
                <input type="checkbox" wire:model.live="selectedMaterialsCreate" value="{{ $material->id }}"
                       class="mr-2 border-indigo-300 rounded shadow-sm text-indigo-500 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50">
                <div class="w-full flex justify-between items-center">
                    <div>
                        <span class="text-gray-800 font-medium">{{ $material->reference }}</span>
                    </div>

                    @if (in_array($material->id, $selectedMaterialsCreate))
                        <div class="flex items-center space-x-4 pr-4">

                            <!-- Cantidad -->
                            <div class="flex flex-col">
                                <label for="quantityCreate_{{ $material->id }}"
                                       class="text-sm text-gray-700 mb-1">Cantidad:</label>
                                <input wire:model.live="quantitiesCreate.{{ $material->id }}"
                                       id="quantityCreate_{{ $material->id }}" min=1 type="number"
                                       class="w-16 px-2 py-1 border-indigo-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Rendimiento -->
                            <div class="flex flex-col">
                                <label for="efficiencyCreate_{{ $material->id }}"
                                       class="text-sm text-gray-700 mb-1">Rendimiento:</label>
                                <input wire:model.live="efficiencyInputsCreate.{{ $material->id }}"
                                       id="efficiencyCreate_{{ $material->id }}" type="text"
                                       class="w-16 px-2 py-1 border-indigo-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Costo parcial -->
                            <div class="flex flex-col">
                                <label for="partialCostCreate_{{ $material->id }}" class="text-sm text-gray-700 mb-1">Costo:</label>
                                <input type="text" readonly
                                       value="{{ isset($partialCostsCreate[$material->id]) ? number_format($partialCostsCreate[$material->id], 2) : 0 }}"
                                       id="partialCostCreate_{{ $material->id }}"
                                       class="w-32 px-2 py-1 border border-indigo-300 rounded-md bg-slate-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">No se encontraron materiales.</li>
        @endforelse
    </ul>

    <!-- Total de materiales -->
    <div class="bg-gray-50 p-2 rounded-lg mb-4 flex items-center">
        <label for="totalMaterialCostCreate" class="block text-lg mr-4 font-medium text-gray-700">Total Materiales:</label>
        <div class="relative rounded-md shadow-sm flex-1">
            <input type="text" readonly value="{{ number_format($totalMaterialCostCreate, 2) }}" id="totalMaterialCostCreate"
                   class="text-right mt-1 p-2 pl-10 block w-full border-indigo-500 rounded-md bg-indigo-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500"></i> COP</span>
            </div>
        </div>

        <div class="ml-4">
            <button wire:click="sendTotalMaterialCostCreate" type="button"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full">
                Enviar
            </button>
        </div>
    </div>
</div>


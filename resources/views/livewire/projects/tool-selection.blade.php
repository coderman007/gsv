<div class="flex flex-col w-full">
    <!-- Sección de búsqueda -->
    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                   class="appearance-none block w-full px-3 py-2 border-2 border-sky-500 rounded-md focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                   placeholder="Buscar herramientas...">
        </div>
    </div>

    <!-- Lista de herramientas -->
    <ul class="overflow-y-auto max-h-96">
        @forelse ($tools as $tool)
            <li class="flex items-center py-2 hover:bg-gray-100">
                <input type="checkbox" wire:model.live="selectedTools" value="{{ $tool->id }}"
                       class="mr-2 border-sky-300 rounded shadow-sm text-sky-500 focus:border-sky-300 focus:ring-sky-200 focus:ring-opacity-50">
                <div class="w-full flex justify-between items-center">
                    <div>
                        <span class="text-gray-800 font-medium">{{ $tool->name }}</span>
                    </div>

                    @if (in_array($tool->id, $selectedTools))
                        <div class="flex items-center">
                            <!-- Campos de cantidades y rendimiento -->
                            <div class="flex space-x-4">
                                <div class="flex flex-col">
                                    <label para="quantity_{{ $tool->id }}" class="text-sm text-gray-700">Cantidad:</label>
                                    <input wire:model.live="quantities.{{ $tool->id }}"
                                           id="quantity_{{ $tool->id }}" type="number"
                                           class="w-16 px-2 py-1 border-sky-300 rounded-md focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                                </div>
                                <div class="flex flex-col">
                                    <label para="required_days_{{ $tool->id }}" class="text-sm text-gray-700">Días:</label>
                                    <input wire:model.live="requiredDays.{{ $tool->id }}"
                                           id="required_days_{{ $tool->id }}" type="number"
                                           class="w-16 px-2 py-1 border-sky-300 rounded-md focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                                </div>
                                <div class="flex flex-col">
                                    <label para="efficiency_{{ $tool->id }}" class="text-sm text-gray-700">Rendimiento:</label>
                                    <input wire:model.live="efficiencies.{{ $tool->id }}"
                                           id="efficiency_{{ $tool->id }}" type="text"
                                           class="w-24 px-2 py-1 border-sky-300 rounded-md focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                                </div>
                            </div>

                            <!-- Costo parcial -->
                            <div class="flex flex-col ml-4">
                                <label para="partialCost_{{ $tool->id }}" class="text-sm text-gray-700">Costo Parcial:</label>
                                <input type="text" readonly
                                       value="{{ isset($partialCosts[$tool->id]) ? number_format($partialCosts[$tool->id], 2) : 0 }}"
                                       id="partialCost_{{ $tool->id }}"
                                       class="w-24 px-2 py-1 border border-sky-300 rounded-md bg-slate-100 focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">No se encontraron herramientas.</li>
        @endforelse
    </ul>

    <!-- Total de herramientas -->
    <div class="bg-gray-50 p-2 rounded-lg mb-4 flex items-center">
        <label para="totalToolCost" class="block text-lg font-medium text-gray-700">Total Herramientas:</label>
        <div class="relative rounded-md shadow-sm flex-1">
            <input type="text" readonly value="{{ number_format($totalToolCost, 2) }}" id="totalToolCost"
                   class="text-right mt-1 p-2 pl-10 block w-full border-sky-500 rounded-md bg-sky-100 focus:outline-none focus:ring-sky-500 focus:border-sky-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500"></i> COP</span>
            </div>
        </div>

        <div class="ml-4">
            <button wire:click="sendTotalToolCost" type="button"
                    class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-full">
                Enviar
            </button>
        </div>
    </div>

</div>

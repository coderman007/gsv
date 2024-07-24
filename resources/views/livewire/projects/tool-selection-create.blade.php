<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="search"
                   id="searchInput"
                   type="text"
                   placeholder="Buscar herramientas ..."
                   class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500 text-sm font-medium text-gray-700">

            @if(strlen($search) > 0)
                @if($tools->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron herramientas que coincidan con la
                        búsqueda.</p>
                @else
                    <ul class="mt-2 border border-sky-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($tools as $tool)
                            @if (!in_array($tool->id, $selectedToolsCreate))
                                <li class="p-2 hover:bg-sky-100 cursor-pointer"
                                    wire:click="addTool({{ $tool->id }})">
                                    {{ $tool->name }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedTools as $tool)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removeTool({{ $tool->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-sky-700">
                            {{ ucfirst($tool->name) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantityCreate{{ $tool->id }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesCreate.{{ $tool->id }}" type="number" min=0 step=1
                               id="quantityCreate{{ $tool->id }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                        @error('quantitiesCreate.' . $tool->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="requiredDaysCreate{{ $tool->id }}" class="block text-sm font-medium text-gray-700">Días Requeridos</label>
                        <input wire:model.live="requiredDaysCreate.{{ $tool->id }}" type="number" min=0 step=1
                               id="requiredDaysCreate{{ $tool->id }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                        @error('requiredDaysCreate.' . $tool->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyInputCreate{{ $tool->id }}" class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsCreate.{{ $tool->id }}" type="text"
                               id="efficiencyInputCreate{{ $tool->id }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                        @error('efficiencyInputsCreate.' . $tool->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostCreate{{ $tool->id }}"
                               class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" id="partialCostCreate{{ $tool->id }}" name="partialCostCreate{{ $tool->id }}"
                               value="{{ number_format($partialCostsCreate[$tool->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-2 mt-6">
            <label for="totalToolCostCreate" class="block text-lg font-semibold text-gray-600">Total Herramientas</label>
            <div class="relative mt-1 px-2 w-full bg-gray-100 border border-sky-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalToolCostCreate" name="totalToolCostCreate"
                       value="$ {{ number_format($totalToolCostCreate, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalToolCostCreate"
                        class="bg-sky-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

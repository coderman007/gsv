<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="toolSearch"
                   id="toolSearchInput"
                   type="text"
                   placeholder="Buscar herramientas ..."
                   class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500 text-sm font-medium text-gray-700">

            @if(strlen($toolSearch) > 0)
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
                        <label for="quantityToolCreate{{ $tool->id }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesToolCreate.{{ $tool->id }}" type="number" min=0 step=1
                               id="quantityToolCreate{{ $tool->id}}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus text-sm font-medium text-gray-700"
                               value="{{ old('quantitiesToolCreate.' . $tool->id, $quantitiesToolCreate[$tool->id] ?? 0) }}">
                    </div>
                    <div>
                        <label for="requiredDaysToolCreate{{ $tool->id }}"
                               class="block text-sm font-medium text-gray-700">Días requeridos</label>
                        <input wire:model.live="requiredDaysToolCreate.{{ $tool->id }}" type="number" min=0 step=1
                               id="requiredDaysToolCreate{{ $tool->id }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500 text-sm font-medium text-gray-700"
                               value="{{ old('requiredDaysToolCreate.' . $tool->id, $requiredDaysToolCreate[$tool->id] ?? 0) }}">
                    </div>

                    <div>
                        <label for="efficiencyToolCreate{{ $tool->id }}"
                               class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsToolCreate.{{ $tool->id }}" type="text"
                               id="efficiencyToolCreate{{ $tool->id }}"
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500 text-sm font-medium text-gray-700"
                               value="{{ old('efficiencyInputsToolCreate.' . $tool->id, $efficiencyInputsToolCreate[$tool->id] ?? '1') }}">
                        @error("efficiencyInputsToolCreate_$tool->id")
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" readonly
                               class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500 text-sm font-medium text-gray-700"
                               value="{{ old('partialCostsToolCreate.' . $tool->id, $partialCostsToolCreate[$tool->id] ?? 0) }}">
                    </div>
                </div>
            @endforeach
        </div>
    </label>
</div>

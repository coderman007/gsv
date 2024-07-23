<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="search"
                   id="searchInput"
                   type="text"
                   placeholder="Buscar posiciones ..."
                   class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm font-medium text-gray-700">

            @if(strlen($search) > 0)
                @if($positions->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron posiciones que coincidan con la búsqueda.</p>
                @else
                    <ul class="mt-2 border border-teal-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($positions as $position)
                            @if (!in_array($position->id, $selectedPositionsCreate))
                                <li class="p-2 hover:bg-teal-100 cursor-pointer"
                                    wire:click="addPosition({{ $position->id }})">
                                    {{ $position->name }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedPositionsCreate as $positionId)
                @php
                    $position = $positions->find($positionId);
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removePosition({{ $positionId }})" class="bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">x</button>
                        <span class="ml-2 text-sm font-medium text-gray-700">{{ $position->name }}</span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantityCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesCreate.{{ $positionId }}" type="number" min=0 step=1
                               id="quantityCreate{{ $positionId }}" name="quantityCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('quantitiesCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="requiredDaysCreate{{ $positionId }}"
                               class="block text-sm font-medium text-gray-700">Días</label>
                        <input wire:model.live="requiredDaysCreate.{{ $positionId }}" type="number" min=0 step=1
                               id="requiredDaysCreate{{ $positionId }}" name="requiredDaysCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('requiredDaysCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Eficiencia</label>
                        <input wire:model.live="efficiencyInputsCreate.{{ $positionId }}" type="text"
                               id="efficiencyCreate{{ $positionId }}" name="efficiencyCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('efficiencyInputsCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" id="partialCostCreate{{ $positionId }}"
                               name="partialCostCreate{{ $positionId }}"
                               value="$ {{ number_format($partialCostsCreate[$positionId] ?? 0, 0, ',') }}" readonly
                               class="mt-1 p-2 block w-full bg-gray-100 border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>
            @endforeach
        </div>
    </label>
    <div class="flex gap-2 mt-6">
        <label for="totalLaborCostCreate" class="block text-lg font-semibold text-gray-600">Costo Total de Mano de Obra</label>
        <input type="text" id="totalLaborCostCreate" name="totalLaborCostCreate" value="$ {{ number_format($totalLaborCostCreate, 0, ',') }}"
               readonly
               class="mt-1 p-2 block w-full bg-gray-100 border-teal-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500">

        <div class="mt-1 flex justify-end">
            <button wire:click="sendTotalLaborCostCreate"
                    class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                Confirmar
            </button>
        </div>
    </div>
</div>

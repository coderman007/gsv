<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="positionSearchEdit"
                   id="positionSearchEditInput"
                   type="text"
                   placeholder="Buscar posiciones de trabajo ..."
                   class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm font-medium text-gray-700">

            @if(strlen($positionSearchEdit) > 0)
                @if($positions->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron posiciones de trabajo que coincidan con la búsqueda.</p>
                @else
                    <ul class="mt-2 border border-teal-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($positions as $position)
                            @if (!in_array($position->id, $selectedPositionsEdit))
                                <li class="p-2 hover:bg-teal-100 cursor-pointer"
                                    wire:click="addPositionEdit({{ $position->id }})">
                                    {{ $position->name }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedPositions as $position)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removePositionEdit({{ $position->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-teal-700">
                            {{ ucfirst($position->name) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantitiesPositionEdit{{ $position->id }}"
                               class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesPositionEdit.{{ $position->id }}" type="number" min=0
                               step=1
                               id="quantitiesPositionEdit{{ $position->id }}"
                               name="quantitiesPositionEdit{{ $position->id }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm font-medium text-gray-700">
                        @error('quantitiesPositionEdit.' . $position->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="requiredDaysPositionEdit{{ $position->id }}"
                               class="block text-sm font-medium text-gray-700">Días</label>
                        <input wire:model.live="requiredDaysPositionEdit.{{ $position->id }}" type="number" min=0
                               step=1
                               id="requiredDaysPositionEdit{{ $position->id }}"
                               name="requiredDaysPositionEdit{{ $position->id }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm font-medium text-gray-700">
                        @error('requiredDaysPositionEdit.' . $position->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyInputsPositionEdit{{ $position->id }}"
                               class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsPositionEdit.{{ $position->id }}" type="text"
                               id="efficiencyInputsPositionEdit{{ $position->id }}"
                               name="efficiencyInputsPositionEdit{{ $position->id }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm font-medium text-gray-700">
                        @error('efficiencyInputsPositionEdit.' . $position->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostsPositionEdit{{ $position->id }}"
                               class="block text-sm font-medium text-gray-700">Costo parcial</label>
                        <input type="text" id="partialCostPositionEdit{{ $position->id }}"
                               name="partialCostPositionEdit{{ $position->id }}"
                               value="$ {{ number_format($partialCostsPositionEdit[$position->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2 mt-6">
            <label for="totalLaborCostEdit" class="block text-lg font-semibold text-gray-600">
                Total Mano de Obra
            </label>
            <div
                class="relative mt-1 px-2 w-full bg-gray-100 border border-teal-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalLaborCostEdit" name="totalLaborCostEdit"
                       value="$ {{ number_format($totalLaborCostEdit, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalLaborCostEdit"
                        class="bg-teal-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

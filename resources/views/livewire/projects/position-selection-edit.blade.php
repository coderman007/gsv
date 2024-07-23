<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
{{--        <h3 class="mb-2 text-left">Mano de Obra</h3>--}}
        <div class="mb-4">
            <label for="positionSelect" class="block text-sm text-left font-medium text-gray-700">Seleccionar Posiciones</label>
            <select id="positionSelect"
                    class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                    wire:change="addPosition($event.target.value)">
                <option value="">Seleccione una posición</option>
                @foreach ($positions as $position)
                    @if (!in_array($position->id, $selectedPositionsEdit))
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedPositionsEdit as $positionId)
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
                        <label for="quantityEdit{{ $positionId }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesEdit.{{ $positionId }}" type="number" min=0 step=1
                               id="quantityEdit{{ $positionId }}" name="quantityEdit{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('quantitiesEdit.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="requiredDaysEdit{{ $positionId }}"
                               class="block text-sm font-medium text-gray-700">Días</label>
                        <input wire:model.live="requiredDaysEdit.{{ $positionId }}" type="number" min=0 step=1
                               id="requiredDaysEdit{{ $positionId }}" name="requiredDaysEdit{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md                    focus:ring-teal-500 focus:border-teal-500">
                        @error('requiredDaysEdit.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyEdit{{ $positionId }}" class="block text-sm font-medium text-gray-700">Eficiencia</label>
                        <input wire:model.live="efficiencyInputsEdit.{{ $positionId }}" type="text"
                               id="efficiencyEdit{{ $positionId }}" name="efficiencyEdit{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('efficiencyInputsEdit.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostEdit{{ $positionId }}" class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <div class="mt-1 flex items-center">
                            <input type="text" id="partialCostEdit{{ $positionId }}" name="partialCostEdit{{ $positionId }}"
                                   value="$ {{ number_format($partialCostsEdit[$positionId] ?? 0, 0, ',') }}" readonly
                                   class="p-2 block w-full bg-gray-100 border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </label>
    <div class="flex gap-2 mt-6">
        <label for="totalLaborCostEdit" class="block text-lg font-semibold text-gray-600">Costo Total de Mano de
            Obra</label>
        <input type="text" id="totalLaborCostEdit" name="totalLaborCostEdit" value="$ {{ number_format($totalLaborCostEdit, 0, ',') }}" readonly
               class="mt-1 p-2 block w-full bg-gray-100 text-lg font-bold border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

        <div class="mt-1 flex justify-end">
            <button wire:click="sendTotalLaborCostEdit"
                    class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                Confirmar
            </button>
        </div>
    </div>
</div>

<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="additionalSearchEdit"
                   id="additionalSearchEditInput"
                   type="text"
                   placeholder="Buscar adicionales ..."
                   class="mt-1 p-2 block w-full border-yellow-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500 text-sm font-medium text-gray-700">

            @if(strlen($additionalSearchEdit) > 0)
                @if($additionals->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron adicionales que coincidan con la
                        búsqueda.</p>
                @else
                    <ul class="mt-2 border border-yellow-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($additionals as $additional)
                            @if (!in_array($additional->id, $selectedAdditionalsEdit))
                                <li class="p-2 hover:bg-yellow-100 cursor-pointer"
                                    wire:click="addAdditionalEdit({{ $additional->id }})">
                                    {{ $additional->name }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedAdditionals as $additional)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removeAdditionalEdit({{ $additional->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-yellow-700">
                            {{ ucfirst($additional->name) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-3 gap-4 mt-2">
                    <div>
                        <label for="quantityAdditionalsEdit{{ $additional->id }}"
                               class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesAdditionalsEdit.{{ $additional->id }}" type="number" min=0
                               step=1
                               id="quantityAdditionalsEdit{{ $additional->id }}"
                               name="quantityAdditionalsEdit{{ $additional->id }}"
                               class="mt-1 p-2 block w-full border-yellow-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500 text-sm font-medium text-gray-700">
                        @error('quantitiesAdditionalsEdit.' . $additional->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyInputsAdditionalsEdit{{ $additional->id }}"
                               class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsAdditionalsEdit.{{ $additional->id }}" type="text"
                               id="efficiencyInputsAdditionalsEdit{{ $additional->id }}"
                               name="efficiencyInputsAdditionalsEdit{{ $additional->id }}"
                               class="mt-1 p-2 block w-full border-yellow-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500 text-sm font-medium text-gray-700">
                        @error('efficiencyInputsAdditionalsEdit.' . $additional->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostsAdditionalsEdit{{ $additional->id }}"
                               class="block text-sm font-medium text-gray-700">Costo parcial</label>
                        <input type="text" id="partialCostAdditionalsEdit{{ $additional->id }}"
                               name="partialCostAdditionalsEdit{{ $additional->id }}"
                               value="$ {{ number_format($partialCostsAdditionalsEdit[$additional->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-yellow-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2 mt-6">
            <label for="totalAdditionalCostEdit" class="block text-lg font-semibold text-gray-600">
                Total Adicionales
            </label>
            <div
                class="relative mt-1 px-2 w-full bg-gray-100 border border-yellow-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalAdditionalCostEdit" name="totalAdditionalCostEdit"
                       value="$ {{ number_format($totalAdditionalCostEdit, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalAdditionalCostEdit"
                        class="bg-yellow-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

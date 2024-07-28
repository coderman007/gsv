<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="transportSearchEdit"
                   id="transportSearchEditInput"
                   type="text"
                   placeholder="Buscar transportes ..."
                   class="mt-1 p-2 block w-full border-lime-300 rounded-md focus:ring-lime-500 focus:border-lime-500 text-sm font-medium text-gray-700">

            @if(strlen($transportSearchEdit) > 0)
                @if($transports->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron transportes que coincidan con la búsqueda.</p>
                @else
                    <ul class="mt-2 border border-lime-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($transports as $transport)
                            @if (!in_array($transport->id, $selectedTransportsEdit))
                                <li class="p-2 hover:bg-lime-100 cursor-pointer"
                                    wire:click="addTransportEdit({{ $transport->id }})">
                                    {{ $transport->vehicle_type }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedTransports as $transport)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removeTransportEdit({{ $transport->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-lime-700">
                            {{ ucfirst($transport->vehicle_type) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantitiesTransportEdit{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesTransportEdit.{{ $transport->id }}" type="number" min=0
                               step=1
                               id="quantitiesTransportEdit{{ $transport->id }}"
                               name="quantitiesTransportEdit{{ $transport->id }}"
                               class="mt-1 p-2 block w-full border-lime-300 rounded-md focus:ring-lime-500 focus:border-lime-500 text-sm font-medium text-gray-700">
                        @error('quantitiesTransportEdit.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="requiredDaysTransportEdit{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Días</label>
                        <input wire:model.live="requiredDaysTransportEdit.{{ $transport->id }}" type="number" min=0
                               step=1
                               id="requiredDaysTransportEdit{{ $transport->id }}"
                               name="requiredDaysTransportEdit{{ $transport->id }}"
                               class="mt-1 p-2 block w-full border-lime-300 rounded-md focus:ring-lime-500 focus:border-lime-500 text-sm font-medium text-gray-700">
                        @error('requiredDaysTransportEdit.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyInputsTransportEdit{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsTransportEdit.{{ $transport->id }}" type="text"
                               id="efficiencyInputsTransportEdit{{ $transport->id }}"
                               name="efficiencyInputsTransportEdit{{ $transport->id }}"
                               class="mt-1 p-2 block w-full border-lime-300 rounded-md focus:ring-lime-500 focus:border-lime-500 text-sm font-medium text-gray-700">
                        @error('efficiencyInputsTransportEdit.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostsTransportEdit{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Costo parcial</label>
                        <input type="text" id="partialCostTransportEdit{{ $transport->id }}"
                               name="partialCostTransportEdit{{ $transport->id }}"
                               value="$ {{ number_format($partialCostsTransportEdit[$transport->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-lime-300 rounded-md focus:ring-lime-500 focus:border-lime-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2 mt-6">
            <label for="totalTransportCostEdit" class="block text-lg font-semibold text-gray-600">
                Total Transporte
            </label>
            <div
                class="relative mt-1 px-2 w-full bg-gray-100 border border-lime-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalTransportCostEdit" name="totalTransportCostEdit"
                       value="$ {{ number_format($totalTransportCostEdit, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalTransportCostEdit"
                        class="bg-lime-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

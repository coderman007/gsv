<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="transportSearch"
                   id="transportSearchInput"
                   type="text"
                   placeholder="Buscar transportes ..."
                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500 text-sm font-medium text-gray-700">

            @if(strlen($transportSearch) > 0)
                @if($transports->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron transportes que coincidan con la
                        búsqueda.</p>
                @else
                    <ul class="mt-2 border border-slate-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($transports as $transport)
                            @if (!in_array($transport->id, $selectedTransportsCreate))
                                <li class="p-2 hover:bg-slate-100 cursor-pointer"
                                    wire:click="addTransport({{ $transport->id }})">
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
                        <button wire:click="removeTransport({{ $transport->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-slate-700">
                            {{ ucfirst($transport->vehicle_type) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantityTransportCreate{{ $transport->id }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesTransportCreate.{{ $transport->id }}" type="number" min=0 step=1
                               id="quantityTransportCreate{{ $transport->id}}"
                               class="mt-1 p-2 block w-full border-slate-300 rounded-md focus text-sm font-medium text-gray-700">
                        {{-- value="{{ old('quantitiesTransportCreate.' . $transport->id, $quantitiesTransportCreate[$transport->id] ?? 0) }}" --}}
                        @error('quantitiesTransportCreate.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="requiredDaysTransportCreate{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Días requeridos</label>
                        <input wire:model.live="requiredDaysTransportCreate.{{ $transport->id }}" type="number" min=0 step=1
                               id="requiredDaysTransportCreate{{ $transport->id }}"
                               class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500 text-sm font-medium text-gray-700">
                        {{-- value="{{ old('requiredDaysTransportCreate.' . $transport->id, $requiredDaysTransportCreate[$transport->id] ?? 0) }}"--}}
                        @error('requiredDaysTransportCreate.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="efficiencyInputTransportCreate{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Rendimiento</label>
                        <input wire:model.live="efficiencyInputsTransportCreate.{{ $transport->id }}" type="text"
                               id="efficiencyInputTransportCreate{{ $transport->id }}"
                               class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">
                        {{-- value="{{ old('efficiencyInputsTransportCreate.' . $transport->id, $efficiencyInputsTransportCreate[$transport->id] ?? '1') }}"--}}
                        @error('efficiencyInputsTransportCreate.' . $transport->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="partialCostTransportCreate{{ $transport->id }}"
                               class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" id="partialCostTransportCreate{{ $transport->id }}"
                               name="partialCostTransportCreate{{ $transport->id }}"
                               value="$ {{ number_format($partialCostsTransportCreate[$transport->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-2 mt-6">
            <label for="totalTransportCostCreate" class="block text-lg font-semibold text-gray-600">Total
                Transporte</label>
            <div
                class="relative mt-1 px-2 w-full bg-gray-100 border border-slate-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalTransportCostCreate" name="totalTransportCostCreate"
                       value="$ {{ number_format($totalTransportCostCreate, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalTransportCostCreate"
                        class="bg-slate-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

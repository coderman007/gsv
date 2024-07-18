<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Transporte</h3>
        <div class="mb-4 grid grid-cols-7 gap-4">
            @foreach ($transports as $transport)
                <!-- Columna 1: Checkbox -->
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedTransportsEdit" type="checkbox" value="{{ $transport->id }}"
                           id="transportEdit{{ $transport->id }}"
                           class="cursor-pointer mr-2 border-slate-300 rounded shadow-sm text-slate-500 focus:border-slate-300 focus:ring focus:ring-slate-200 focus:ring-opacity-50">
                    <label for="transportEdit{{ $transport->id }}"
                           class="block text-sm font-medium text-gray-700">{{ $transport->vehicle_type }}</label>
                </div>
                <!-- Columna 2: Cantidad -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsEdit))
                        <div class="mb-2">
                            <label for="quantityEdit{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantitiesEdit.{{ $transport->id }}" type="number" min=0 step=1
                                   id="quantityEdit{{ $transport->id }}" name="quantityEdit{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('quantitiesEdit.' . $transport->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <!-- Columna 3: Días Requeridos -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsEdit))
                        <div class="mb-2">
                            <label for="requiredDaysEdit{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Días</label>
                            <input wire:model.live="requiredDaysEdit.{{ $transport->id }}" type="number" min=0 step=1
                                   id="requiredDaysEdit{{ $transport->id }}" name="requiredDaysEdit{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('requiredDaysEdit.' . $transport->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 4: Rendimiento -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsEdit))
                        <div class="mb-2">
                            <label for="efficiencyEdit{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Rendimiento</label>
                            <input wire:model.live="efficiencyInputsEdit.{{ $transport->id }}" type="text"
                                   id="efficiencyEdit{{ $transport->id }}" name="efficiencyEdit{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error("efficiencyInputsEdit.{{ $transport->id }}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 5: Costo Parcial -->
                <div class="col-span-2">
                    @if (in_array($transport->id, $selectedTransportsEdit))
                        <div class="mb-2">
                            <label for="partialCostEdit{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                   value="{{ isset($partialCostsEdit[$transport->id]) ? number_format($partialCostsEdit[$transport->id], 2) : 0 }}"
                                   id="partialCostEdit{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md bg-slate-100 focus:ring-slate-500 focus:border-slate-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedTransportsEdit')
            <span class="col-span-8 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Total de transporte -->
        <div class="col-span-2 flex items-center">
            <label for="totalTransportCostEdit" class="block text-lg text-gray-700">Total Transporte:</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalTransportCostEdit, 2) }}" id="totalTransportCostEdit"
                       class="text-right mt-1 p-2 block w-full border-slate-500 rounded-md bg-slate-100 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500"></i> COP</span>
                </div>
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalTransportCostEdit" type="button"
                        class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>

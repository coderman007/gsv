<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Transporte</h3>
        <div class="mb-4 grid grid-cols-7 gap-4">
            @foreach ($transports as $transport)
                <!-- Columna 1: Checkbox -->
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedTransportsCreate" type="checkbox" value="{{ $transport->id }}"
                           id="transportCreate{{ $transport->id }}"
                           class="cursor-pointer mr-2 border-slate-300 rounded shadow-sm text-slate-500 focus:border-slate-300 focus:ring focus:ring-slate-200 focus:ring-opacity-50">
                    <label for="transportCreate{{ $transport->id }}"
                           class="block text-sm font-medium text-gray-700">{{ $transport->vehicle_type }}</label>
                </div>
                <!-- Columna 2: Cantidad -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsCreate))
                        <div class="mb-2">
                            <label for="quantityCreate{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantitiesCreate.{{ $transport->id }}" type="number" min=0 step=1
                                   id="quantityCreate{{ $transport->id }}" name="quantityCreate{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('quantitiesCreate.' . $transport->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <!-- Columna 3: Días Requeridos -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsCreate))
                        <div class="mb-2">
                            <label for="requiredDaysCreate{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Días</label>
                            <input wire:model.live="requiredDaysCreate.{{ $transport->id }}" type="number" min=0 step=1
                                   id="requiredDaysCreate{{ $transport->id }}" name="requiredDaysCreate{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('requiredDaysCreate.' . $transport->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 4: Rendimiento -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransportsCreate))
                        <div class="mb-2">
                            <label for="efficiencyCreate{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Rendimiento</label>
                            <input wire:model.live="efficiencyInputsCreate.{{ $transport->id }}" type="text"
                                   id="efficiencyCreate{{ $transport->id }}" name="efficiencyCreate{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error("efficiencyInputsCreate.{{ $transport->id }}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 5: Costo Parcial -->
                <div class="col-span-2">
                    @if (in_array($transport->id, $selectedTransportsCreate))
                        <div class="mb-2">
                            <label for="partialCostCreate{{ $transport->id }}"
                                   class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                   value="{{ isset($partialCostsCreate[$transport->id]) ? number_format($partialCostsCreate[$transport->id], 2) : 0 }}"
                                   id="partialCostCreate{{ $transport->id }}"
                                   class="mt-1 p-2 block w-full border-slate-300 rounded-md bg-slate-100 focus:ring-slate-500 focus:border-slate-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedTransportsCreate')
            <span class="col-span-8 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Total de transporte -->
        <div class="col-span-2 flex items-center">
            <label for="totalTransportCostCreate" class="block text-lg text-gray-700">Total Transporte:</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalTransportCostCreate, 2) }}" id="totalTransportCostCreate"
                       class="text-right mt-1 p-2 block w-full border-slate-500 rounded-md bg-slate-100 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm"><i class="fas fa-coins ml-1 text-yellow-500"></i> COP</span>
                </div>
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalTransportCostCreate" type="button"
                        class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>

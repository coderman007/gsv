<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Transporte</h3>
        <!-- Selección de Transportes y Configuración -->
        <div class="mb-4 grid grid-cols-5 gap-4">
            @foreach ($transports as $transport)
                <!-- Columna 1: Checkbox -->
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedTransports" type="checkbox" value="{{ $transport->id }}"
                        id="transport{{ $transport->id }}"
                        class="mr-2 border-slate-300 rounded shadow-sm text-slate-500 focus:border-slate-300 focus:ring focus:ring-slate-200 focus:ring-opacity-50">
                    <label for="transport{{ $transport->id }}"
                        class="block text-sm font-medium text-gray-700">{{ $transport->vehicle_type }}</label>
                </div>
                <!-- Columna 2: Cantidad -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransports))
                        <div class="mb-2">
                            <label for="quantity{{ $transport->id }}"
                                class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantities.{{ $transport->id }}" type="number"
                                id="quantity{{ $transport->id }}" name="quantity{{ $transport->id }}"
                                class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('quantities.' . $loop->index)
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <!-- Columna 3: Días Requeridos -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransports))
                        <div class="mb-2">
                            <label for="requiredDays{{ $transport->id }}"
                                class="block text-sm font-medium text-gray-700">Días Requeridos</label>
                            <input wire:model.live="requiredDays.{{ $transport->id }}" type="number"
                                id="requiredDays{{ $transport->id }}" name="requiredDays{{ $transport->id }}"
                                class="mt-1 p-2 block w-full border-slate-300 rounded-md focus:ring-slate-500 focus:border-slate-500">

                            @error('requiredDays.' . $loop->index)
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 4: Costo Parcial -->
                <div class="col-span-1">
                    @if (in_array($transport->id, $selectedTransports))
                        <div class="mb-2">
                            <label for="partialCost{{ $loop->index }}"
                                class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                value="{{ isset($partialCosts[$transport->id]) ? number_format($partialCosts[$transport->id], 2) : 0 }}"
                                id="partialCost{{ $transport->id }}"
                                class="mt-1 p-2 block w-full border-slate-300 rounded-md bg-slate-100 focus:ring-slate-500 focus:border-slate-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedTransports')
                <span class="col-span-8 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Columna 5: Costo Total de Transporte -->
        <div class="col-span-2 flex items-center">
            <label for="totalTransportCost" class="block text-lg font-medium mr-4 text-gray-700">Total
                Transporte</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly wire:model.live="formattedTotalTransportCost" id="totalTransportCost"
                    class="text-right mt-1 p-2 pl-10 block w-full border-slate-500 rounded-md bg-slate-100 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm"><i
                            class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP</span>
                </div>
            </div>
            <div class="ml-4">
                <button wire:click="sendTotalTransportCost" type="button"
                    class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>

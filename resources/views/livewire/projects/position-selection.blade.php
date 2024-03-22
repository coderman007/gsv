<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Mano de Obra</h3>
        <!-- Selección de Posiciones y Configuración -->
        <div class="mb-4 grid grid-cols-5 gap-4">
            @foreach ($allPositions as $position)
                <!-- Columna 1: Checkbox -->
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedPositions" type="checkbox" value="{{ $position->id }}"
                        id="position{{ $position->id }}"
                        class="mr-2 border-teal-300 rounded shadow-sm text-teal-500 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <label for="position{{ $position->id }}"
                        class="block text-sm font-medium text-gray-700">{{ $position->name }}</label>
                </div>
                <!-- Columna 2: Cantidad -->
                <div class="col-span-1">
                    @if (in_array($position->id, $selectedPositions))
                        <div class="mb-2">
                            <label for="quantity{{ $position->id }}"
                                class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="positionQuantities.{{ $position->id }}" type="number"
                                id="quantity{{ $position->id }}" name="quantity{{ $position->id }}"
                                class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                            @error('positionQuantities.' . $loop->index)
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <!-- Columna 3: Días Requeridos -->
                <div class="col-span-1">
                    @if (in_array($position->id, $selectedPositions))
                        <div class="mb-2">
                            <label for="requiredDays{{ $position->id }}"
                                class="block text-sm font-medium text-gray-700">Días
                                Requeridos</label>
                            <input wire:model.live="positionRequiredDays.{{ $position->id }}" type="number"
                                id="requiredDays{{ $position->id }}" name="requiredDays{{ $position->id }}"
                                class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                            @error('positionRequiredDays.' . $loop->index)
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Columna 4: Costo Parcial -->
                <div class="col-span-1">
                    @if (in_array($position->id, $selectedPositions))
                        <div class="mb-2">
                            <label for="partialCost{{ $loop->index }}"
                                class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                value="{{ isset($partialCosts[$position->id]) ? number_format($partialCosts[$position->id], 2) : 0 }}"
                                id="partialCost{{ $position->id }}"
                                class="mt-1 p-2 block w-full border-teal-300 rounded-md bg-teal-100 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedPositions')
                <span class="col-span-8 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Columna 5: Costo Total de Mano de Obra -->
        <div class="col-span-2 flex items-center">
            <!-- Cambié 'col-span-1' a 'col-span-2' para ocupar dos columnas y añadí la clase 'flex items-center' -->
            <label for="totalLaborCost" class="block text-lg font-medium mr-4 text-gray-700">Total Mano de Obra</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly wire:model="formattedTotalLaborCost" id="totalLaborCost"
                    class="text-right mt-1 p-2 pl-10 block w-full border-teal-500 rounded-md bg-teal-100 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm"><i
                            class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP</span>
                </div>
            </div>
       
            <!-- Cambié 'col-span-1' a 'col-span-2' para ocupar dos columnas y añadí la clase 'flex items-center' -->
            <div class="ml-4">
                <button wire:click="sendTotalLaborCost" type="button"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>


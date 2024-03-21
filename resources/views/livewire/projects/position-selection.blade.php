<div>
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Mano de Obra</h3>
        <!-- Selección de Posiciones y Configuración -->
        <div class="mb-4 grid grid-cols-5 gap-4">
            @foreach ($allPositions as $position)
                <!-- Columna 1: Checkbox -->
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedPositions" type="checkbox" value="{{ $position->id }}"
                        id="position{{ $position->id }}"
                        class="mr-2 border-gray-300 rounded shadow-sm text-blue-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
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
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md">

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
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md">

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
                                value="{{ isset($partialCosts[$position->id]) ? $partialCosts[$position->id] : 0 }}"
                                id="partialCost{{ $position->id }}"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md bg-gray-100">

                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedPositions')
                <span class="col-span-8 text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </label>
</div>

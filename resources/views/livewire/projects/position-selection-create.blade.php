<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Mano de Obra</h3>
        <div class="mb-4 grid grid-cols-7 gap-4">
            @foreach ($positions as $position)
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedPositionsCreate" type="checkbox" value="{{ $position->id }}"
                           id="positionCreate{{ $position->id }}"
                           class="cursor-pointer mr-2 border-teal-300 rounded shadow-sm text-teal-500 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <label for="positionCreate{{ $position->id }}"
                           class="block text-sm font-medium cursor-pointer text-gray-700">{{ $position->name }}</label>
                </div>
                <div class="col-span-1">
                    @if (in_array($position->id, $selectedPositionsCreate))
                        <div class="mb-2">
                            <label for="quantityCreate{{ $position->id }}"
                                   class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantitiesCreate.{{ $position->id }}" type="number" min=0 step=1
                                   id="quantityCreate{{ $position->id }}" name="quantityCreate{{ $position->id }}"
                                   class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                            @error('quantitiesCreate.' . $position->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="col-span-1">
                    @if (in_array($position->id, $selectedPositionsCreate))
                        <div class="mb-2">
                            <label for="requiredDaysCreate{{ $position->id }}"
                                   class="block text-sm font-medium text-gray-700">Días</label>
                            <input wire:model.live="requiredDaysCreate.{{ $position->id }}" type="number" min=0 step=1
                                   id="requiredDaysCreate{{ $position->id }}" name="requiredDaysCreate{{ $position->id }}"
                                   class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                            @error('requiredDaysCreate.' . $position->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                @if (in_array($position->id, $selectedPositionsCreate))
                    <div class="col-span-1">
                        <div class="mb-2">
                            <label for="efficiencyCreate{{ $position->id }}"
                                   class="block text-sm font-medium text-gray-700">Rendimiento</label>
                            <input wire:model.live="efficiencyInputsCreate.{{ $position->id }}" type="text"
                                   id="efficiencyCreate{{ $position->id }}"
                                   class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                            @error("efficiencyInputsCreate.{{ $position->id }}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="col-span-2">
                    @if (in_array($position->id, $selectedPositionsCreate))
                        <div class="mb-2">
                            <label for="partialCostCreate{{ $position->id }}"
                                   class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                   value="{{ isset($partialCostsCreate[$position->id]) ? number_format($partialCostsCreate[$position->id], 2) : 0 }}"
                                   id="partialCostCreate{{ $position->id }}"
                                   class="mt-1 p-2 block w-full border-teal-300 rounded-md bg-teal-100 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedPositionsCreate')
            <span class="col-span-7 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 flex items-center">
            <label for="totalLaborCostCreate" class="block text-lg font-medium mr-4 text-gray-700">Total Mano de Obra</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalLaborCostCreate, 2) }}" id="totalLaborCostCreate"
                       class="text-right mt-1 p-2 pl-10 block w-full border-teal-500 rounded-md bg-teal-100 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <span class="text-gray-500 sm:text-sm">
                    <i class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP
                </span>
                </div>
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalLaborCostCreate" type="button"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>


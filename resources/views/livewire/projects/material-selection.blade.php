<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Materiales</h3>
        <div class="mb-4 grid grid-cols-7 gap-4">
            @foreach ($materials as $material)
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedMaterials" type="checkbox" value="{{ $material->id }}"
                           id="material{{ $material->id }}"
                           class="cursor-pointer mr-2 border-indigo-300 rounded shadow-sm text-indigo-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="material{{ $material->id }}"
                           class="block text-sm font-medium cursor-pointer text-gray-700">{{ $material->reference }}</label>
                </div>
                <div class="col-span-1">
                    @if (in_array($material->id, $selectedMaterials))
                        <div class="mb-2">
                            <label for="quantity{{ $material->id }}"
                                   class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantities.{{ $material->id }}" type="number"
                                   id="quantity{{ $material->id }}" name="quantity{{ $material->id }}"
                                   class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @error('quantities.' . $material->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="col-span-1">
                    @if (in_array($material->id, $selectedMaterials))
                        <div class="mb-2">
                            <label for="efficiency{{ $material->id }}"
                                   class="block text-sm font-medium text-gray-700">Rendimiento</label>
                            <input wire:model.live="efficiencyInputs.{{ $material->id }}" type="text"
                                   id="efficiency{{ $material->id }}"
                                   class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @error("efficiencyInputs.{{ $material->id }}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="col-span-2">
                    @if (in_array($material->id, $selectedMaterials))
                        <div class="mb-2">
                            <label for="partialCost{{ $material->id }}"
                                   class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                   value="{{ isset($partialCosts[$material->id]) ? number_format($partialCosts[$material->id], 2) : 0 }}"
                                   id="partialCost{{ $material->id }}"
                                   class="mt-1 p-2 block w-full border-indigo-300 rounded-md bg-indigo-100 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedMaterials')
            <span class="col-span-7 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 flex items-center">
            <label for="totalMaterialCost" class="block text-lg font-medium mr-4 text-gray-700">Total Materiales</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalMaterialCost, 2) }}" id="totalMaterialCost"
                       class="text-right mt-1 p-2 pl-10 block w-full border-indigo-500 rounded-md bg-indigo-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm">
                        <i class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP
                    </span>
                </div>
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalMaterialCost" type="button"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>

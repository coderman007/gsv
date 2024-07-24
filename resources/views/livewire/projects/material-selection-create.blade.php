<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <div class="mb-4">
            <input wire:model.live="materialSearch"
                   id="searchInput"
                   type="text"
                   placeholder="Buscar materiales ..."
                   class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium text-gray-700">

            @if(strlen($materialSearch) > 0)
                @if($materials->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">No se encontraron materiales que coincidan con la búsqueda.</p>
                @else
                    <ul class="mt-2 border border-indigo-300 rounded-md max-h-60 overflow-y-auto text-sm">
                        @foreach ($materials as $material)
                            @if (!in_array($material->id, $selectedMaterialsCreate))
                                <li class="p-2 hover:bg-indigo-100 cursor-pointer" wire:click="addMaterial({{ $material->id }})">
                                    {{ $material->reference }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedMaterials as $material)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removeMaterial({{ $material->id }})"
                                class="ml-5 bg-red-100 text-sm hover:bg-red-200 text-red-500 hover:text-red-800 rounded-md px-3 py-1">
                            x
                        </button>
                        <span class="ml-2 text-sm font-medium text-indigo-700">
                            {{ ucfirst($material->reference) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-3 gap-4 mt-2">
                    <div>
                        <label for="quantityMaterialCreate{{ $material->id }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesMaterialCreate.{{ $material->id }}" type="number" min=0 step=1
                               id="quantityMaterialCreate{{ $material->id }}" name="quantityMaterialCreate{{ $material->id }}"
                               class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('quantitiesMaterialCreate.' . $material->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyMaterialCreate{{ $material->id }}" class="block text-sm font-medium text-gray-700">Eficiencia</label>
                        <input wire:model.live="efficiencyInputsMaterialCreate.{{ $material->id }}" type="text"
                               id="efficiencyMaterialCreate{{ $material->id }}" name="efficiencyMaterialCreate{{ $material->id }}"
                               class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('efficiencyInputsMaterialCreate.' . $material->id)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostMaterialCreate{{ $material->id }}"
                               class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" id="partialCostMaterialCreate{{ $material->id }}" name="partialCostMaterialCreate{{ $material->id }}"
                               value="{{ number_format($partialCostsMaterialCreate[$material->id] ?? 0, 0, ',') }}"
                               class="mt-1 p-2 block w-full border-indigo-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                               readonly>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-2 mt-6">
            <label for="totalMaterialCostCreate" class="block text-lg font-semibold text-gray-600">
                Total Materiales
            </label>
            <div
                class="relative mt-1 px-2 w-full bg-gray-100 border border-indigo-300 font-bold text-lg rounded-md focus:ring-teal-500 focus:border-teal-500 flex items-center">
                <i class="fas fa-coins ml-1 text-yellow-500"></i>
                <input type="text" id="totalMaterialCostCreate" name="totalMaterialCostCreate"
                       value="$ {{ number_format($totalMaterialCostCreate, 0, ',') }}" readonly
                       class="ml-2 bg-transparent border-none focus:ring-0">
            </div>
            <div class="mt-1 flex justify-end">
                <button wire:click="sendTotalMaterialCostCreate"
                        class="bg-indigo-500 text-white px-4 py-2 text-sm font-semibold rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </label>
</div>

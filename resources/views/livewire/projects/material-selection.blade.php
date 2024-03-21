<div class="flex flex-col w-full">
    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Buscar materiales...">
        </div>
        <button wire:click="dispatchSelectedMaterials"
            class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700">
            Finalizar selección
        </button>
    </div>

    <ul class="overflow-y-auto max-h-96">
        @forelse ($materials as $material)
            <li class="flex items-center py-2 hover:bg-gray-100">
                <input type="checkbox" wire:model.live="selectedMaterials" value="{{ $material->id }}" class="mr-2">
                <div class="w-full">
                    <span class="text-gray-800 font-medium">{{ $material->reference }}</span>
                    <p class="text-gray-600 text-sm">{{ $material->description }}</p>
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">No se encontraron materiales.</li>
        @endforelse
    </ul>
</div>

<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Herramientas</h3>
        <div class="mb-4 grid grid-cols-7 gap-4">
            @foreach ($tools as $tool)
                <div class="flex items-center col-span-2">
                    <input wire:model.live="selectedTools" type="checkbox" value="{{ $tool->id }}"
                           id="tool{{ $tool->id }}"
                           class="cursor-pointer mr-2 border-sky-300 rounded shadow-sm text-sky-500 focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50">
                    <label for="tool{{ $tool->id }}"
                           class="block text-sm font-medium cursor-pointer text-gray-700">{{ $tool->name }}</label>
                </div>
                <div class="col-span-1">
                    @if (in_array($tool->id, $selectedTools))
                        <div class="mb-2">
                            <label for="quantity{{ $tool->id }}"
                                   class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model.live="quantities.{{ $tool->id }}" type="number" min=0 step=1
                                   id="quantity{{ $tool->id }}" name="quantity{{ $tool->id }}"
                                   class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                            @error('quantities.' . $tool->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="col-span-1">
                    @if (in_array($tool->id, $selectedTools))
                        <div class="mb-2">
                            <label for="requiredDays{{ $tool->id }}"
                                   class="block text-sm font-medium text-gray-700">Días</label>
                            <input wire:model.live="requiredDays.{{ $tool->id }}" type="number" min=0 step=1
                                   id="requiredDays{{ $tool->id }}" name="requiredDays{{ $tool->id }}"
                                   class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                            @error('requiredDays.' . $tool->id)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="col-span-1">
                    @if (in_array($tool->id, $selectedTools))
                        <div class="mb-2">
                            <label for="efficiency{{ $tool->id }}"
                                   class="block text-sm font-medium text-gray-700">Rendimiento</label>
                            <input wire:model.live="efficiencyInputs.{{ $tool->id }}" type="text"
                                   id="efficiency{{ $tool->id }}"
                                   class="mt-1 p-2 block w-full border-sky-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
                            @error("efficiencyInputs.{{ $tool->id }}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="col-span-2">
                    @if (in_array($tool->id, $selectedTools))
                        <div class="mb-2">
                            <label for="partialCost{{ $tool->id }}"
                                   class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                            <input type="text" readonly
                                   value="{{ isset($partialCosts[$tool->id]) ? number_format($partialCosts[$tool->id], 2) : 0 }}"
                                   id="partialCost{{ $tool->id }}"
                                   class="mt-1 p-2 block w-full border-sky-300 rounded-md bg-sky-100 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    @endif
                </div>
            @endforeach
            @error('selectedTools')
            <span class="col-span-7 text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 flex items-center">
            <label for="totalToolCost" class="block text-lg font-medium mr-4 text-gray-700">Total Herramientas</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalToolCost, 2) }}" id="totalToolCost"
                       class="text-right mt-1 p-2 pl-10 block w-full border-sky-500 rounded-md bg-sky-100 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <span class="text-gray-500 sm:text-sm">
                        <i class="fas fa-coins ml-1 text-yellow-500 mr-2"></i>COP
                    </span>
                </div>
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalToolCost" type="button"
                        class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-full">
                    Enviar
                </button>
            </div>
        </div>
    </label>
</div>

<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Proyecto</span>
    </button>

    <x-dialog-modal maxWidth="7xl" wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Proyecto</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <div>
                    <form wire:submit.prevent="saveProject" class="p-4 bg-white rounded shadow-md">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="name" class="text-lg font-semibold text-gray-600 py-2">Nombre del
                                    Proyecto</label>
                                <input wire:model="name" type="text" id="name" name="name"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="text-lg font-semibold text-gray-600 py-2">Descripción
                                    del Proyecto</label>
                                <textarea wire:model="description" id="description" name="description" rows="3"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md"></textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="kilowatts_to_provide"
                                    class="text-lg font-semibold text-gray-600 py-2">Kilovatios a Proveer</label>
                                <input wire:model="kilowatts_to_provide" type="number" id="kilowatts_to_provide"
                                    name="kilowatts_to_provide"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                @error('kilowatts_to_provide')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="status" class="text-lg font-semibold text-gray-600 py-2">Estado del
                                    Proyecto</label>
                                <select wire:model="status" id="status" name="status"
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo para mostrar el valor total de la mano de obra -->
                            <div class="mb-4">
                                <label for="totalLaborCost" class="text-lg font-semibold text-gray-600 py-2">Costo Total
                                    de Mano de Obra</label>
                                <input wire:model="totalLaborCost" type="text" id="totalLaborCost"
                                    name="totalLaborCost" readonly
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            </div>

                            <!-- Campo para mostrar el valor total de los materiales -->
                            <div class="mb-4">
                                <label for="totalMaterialsCost" class="text-lg font-semibold text-gray-600 py-2">Costo
                                    Total
                                    de Materiales</label>
                                <input wire:model="totalMaterialsCost" type="text" id="totalMaterialsCost"
                                    name="totalMaterialsCost" readonly
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            </div>

                            <!-- Campo para mostrar el valor total de las herramnientas -->
                            <div class="mb-4">
                                <label for="totalToolsCost" class="text-lg font-semibold text-gray-600 py-2">Costo
                                    Total
                                    de Herramientas</label>
                                <input wire:model="totalToolsCost" type="text" id="totalToolsCost"
                                    name="totalToolsCost" readonly
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            </div>

                            <!-- Campo para mostrar el valor total del transporte -->
                            <div class="mb-4">
                                <label for="totalTransportCost" class="text-lg font-semibold text-gray-600 py-2">Costo
                                    Total
                                    del transporte</label>
                                <input wire:model="totalTransportCost" type="text" id="totalTransportCost"
                                    name="totalTransportCost" readonly
                                    class="mt-1 p-2 block w-full border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold mb-4">Recursos del Proyecto</h2>
                                <div class="flex justify-center space-x-4">
                                    <button wire:click="showLaborForm"
                                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Mano
                                        de obra</button>
                                    <button wire:click="showMaterialsForm"
                                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Materiales</button>
                                    <button wire:click="showToolsForm"
                                        class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Herramientas</button>
                                    <button wire:click="showTransportForm"
                                        class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-full"
                                        type="button">Transporte</button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <!-- Mostrar componente Livewire correspondiente -->
                                @if ($showResource === 'labor')
                                    <livewire:projects.position-selection />
                                @elseif ($showResource === 'materials')
                                    <livewire:projects.material-selection />
                                @elseif ($showResource === 'tools')
                                    <livewire:projects.tool-selection />
                                @elseif ($showResource === 'transport')
                                    <livewire:projects.transport-selection />
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </x-slot>
            <x-slot name="footer">
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

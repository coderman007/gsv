<div>
    <div>
        <button wire:click="$set('openCreate', true)"
            class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Crear Cotización</button>
    </div>

    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <div class="pr-10">
                <h2 class="mt-3 text-2xl text-right">Cotización N° </h2>
            </div>
        </x-slot>

        <div>
            <x-slot name="content">
                <form wire:submit.prevent="guardarCotizacion" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Proyecto</label>
                        <select wire:model="project_id" id="project_id" class="mt-1 p-2 w-full rounded-md">
                            <option value="" disabled selected>Selecciona un proyecto</option>
                            <!-- Opciones de proyectos -->
                        </select>
                        @error('project_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select wire:model="client_id" id="client_id" class="mt-1 p-2 w-full rounded-md">
                            <option value="" disabled selected>Selecciona un cliente</option>
                            <!-- Opciones de clientes -->
                        </select>
                        @error('client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="quotation_date" class="block text-sm font-medium text-gray-700">Fecha de
                            Cotización</label>
                        <input wire:model="quotation_date" type="date" id="quotation_date"
                            class="mt-1 p-2 w-full rounded-md">
                        @error('quotation_date') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="validity_period" class="block text-sm font-medium text-gray-700">Período de Validez
                            (días)</label>
                        <input wire:model="validity_period" type="number" id="validity_period"
                            class="mt-1 p-2 w-full rounded-md">
                        @error('validity_period') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="total_quotation_amount" class="block text-sm font-medium text-gray-700">Monto Total
                            de la Cotización</label>
                        <input wire:model="total_quotation_amount" type="number" step="0.01" id="total_quotation_amount"
                            class="mt-1 p-2 w-full rounded-md">
                        @error('total_quotation_amount') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Otros campos del formulario según tus necesidades -->

                </form>

                <!-- Muestra un mensaje de éxito si existe -->
                @if(session()->has('message'))
                <div class="mt-4 bg-green-500 text-white p-2 rounded">
                    {{ session('message') }}
                </div>
                @endif

            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-between mb-4">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded"
                        wire:click="guardarCotizacion">Guardar</button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>
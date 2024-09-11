<div class="max-w-7xl mx-auto p-6 bg-gray-50 shadow-lg rounded-xl">
    <!-- Modal de Confirmación de Eliminación -->
    @if ($openDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" wire:click="$set('openDeleteModal', false)">
            <div class="bg-white p-6 rounded-lg" wire:click.stop>
                <h2 class="text-xl font-bold">Confirmar Eliminación</h2>
                <p>¿Estás seguro de eliminar esta variable macroeconómica?</p>
                <div class="mt-4 flex gap-2">
                    <button wire:click="$set('openDeleteModal', false)" class="bg-gray-500 text-white py-2 px-4 rounded">Cancelar</button>
                    <button wire:click="deleteVariable" class="bg-red-500 text-white py-2 px-4 rounded">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Título Centrando para la Vista General -->
    <div class="text-center mb-8">
        <h2 class="text-4xl font-semibold text-gray-900">Variables Macroeconómicas</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Columna Izquierda: Formulario (1/3 de la pantalla) -->
        <div class="col-span-1 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-semibold mb-4 text-gray-900 text-center">
                {{ $isEditMode ? 'Edición' : 'Creación' }}
            </h3>

            <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <input type="text" id="name" wire:model="name" placeholder="Nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="number" step="0.001" id="value" wire:model="value" placeholder="Valor" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('value') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="text" id="unit" wire:model="unit" placeholder="Unidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('unit') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <textarea id="description" wire:model="description" placeholder="Descripción" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="date" id="effective_date" wire:model="effective_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('effective_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
                </button>
            </form>
        </div>

        <!-- Columna Derecha: Tabla (2/3 de la pantalla) -->
        <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Nombre</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Valor</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Unidad</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Descripción</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Fecha de Efectividad</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach($variables as $variable)
                        <tr>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $variable->name }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $variable->value }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $variable->unit }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $variable->description }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $variable->effective_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 flex gap-2">
                                <button wire:click="edit({{ $variable->id }})" class="py-1 px-3 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">Editar</button>
                                <button wire:click="confirmDelete({{ $variable->id }})" class="py-1 px-3 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Notificación de creación de variables macroeconómicas
            Livewire.on('createdMacroEconomicVariableNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Variable Macroeconómica Creada!',
                    text: 'La variable macroeconómica se ha creado correctamente!'
                });
            });

            // Notificación de edición de variables macroeconómicas
            Livewire.on('updatedMacroEconomicVariableNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Variable Macroeconómica Actualizada!',
                    text: 'La variable macroeconómica se ha actualizado correctamente!'
                });
            });

            // Notificación de eliminación de variables macroeconómicas
            Livewire.on('deletedMacroEconomicVariableNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Variable Macroeconómica Eliminada!',
                    text: 'La variable macroeconómica se ha eliminado correctamente!'
                });
            });
        </script>
    @endpush
</div>

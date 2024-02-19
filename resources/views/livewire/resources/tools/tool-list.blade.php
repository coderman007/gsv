<div class="container mx-auto mt-8">

    {{-- Barra de búsqueda --}}
    <div class="grid items-center w-full md:grid-cols-12 mt-4">
        <div class="col-span-4 ml-4 shadow-md shadow-gray-500 border dark:border-blue-500 rounded-lg">
            <input type="text" name="search" wire:model.live="search"
                class="w-full bg-white dark:text-gray-100 dark:bg-gray-900 border-none rounded-lg focus:ring-blue-400"
                placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Herramientas</h1>
            </div>
        </div>
        <div class="col-span-4 mt-4 md:mt-0 md:block md:col-span-4">
            <div class="md:text-right">
                <livewire:resources.tools.tool-create />
            </div>
        </div>
    </div>

    {{-- Resultados y selección de resultados por página --}}
    <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
        Resultados
        <select name="perSearch" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>

    {{-- Tabla de Herramientas --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-0">
                <div class="overflow-hidden border border-gray-300 dark:border-gray-700 shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-300">
                            <tr>
                                <!-- Ajusta las columnas según tu modelo de Tool -->
                                <th data-title="Ordenar por ID" wire:click="order('id')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    ID
                                    @if ($sortBy == 'id')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>
                                <th data-title="Ordenar por categoría" wire:click="order('category')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Categoría
                                    @if ($sortBy == 'category')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>
                                <th data-title="Ordenar por nombre" wire:click="order('name')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Nombre
                                    @if ($sortBy == 'name')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>
                                <th data-title="Ordenar por precio unitario" wire:click="order('unit_price')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Precio Unitario
                                    @if ($sortBy == 'unit_price')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>
                                <!-- Agrega más columnas según sea necesario -->
                                <th
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($tools as $tool)
                            <tr wire:key="tool-list-{{ $tool->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <!-- Ajusta las columnas según tu modelo de Tool -->
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $tool->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->unit_price }}</td>
                                <!-- Agrega más columnas según sea necesario -->
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <div class="flex items-center">
                                        <livewire:resources.tools.tool-show :tool='$tool'
                                            wire:key='tool-show{{ $tool->id}}' />
                                        <livewire:resources.tools.tool-edit :toolId='$tool->id'
                                            wire:key='tool-edit-{{ $tool->id}}' />
                                        <livewire:resources.tools.tool-delete :tool='$tool'
                                            wire:key='tool-delete-{{ $tool->id}}' />
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $tools->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mensaje si no hay herramientas --}}
    @if ($tools->count() === 0)
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    <div class="flex justify-center w-full h-auto">
        <button
            class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
            <a href="{{ route('tools') }}">Volver</a>
        </button>
    </div>
    @endif

    {{-- Scripts para notificaciones --}}
    @push('js')
    <script>
        Livewire.on('createdToolNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Herramienta Creada!'
                    , text: 'La herramienta se ha creado correctamente!'
                })
            });

            Livewire.on('updatedToolNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Herramienta Actualizada!'
                    , text: 'La herramienta se ha actualizado correctamente!'
                })
            });

            Livewire.on('deletedToolNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Herramienta Eliminada!'
                    , text: 'La herramienta se ha eliminado correctamente!'
                })
            });
    </script>
    @endpush

</div>
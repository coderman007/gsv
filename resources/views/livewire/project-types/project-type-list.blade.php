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
                <h1>Tipos de Proyectos</h1>
            </div>
        </div>
        <div class="col-span-4 mt-4 md:mt-0 md:block md:col-span-4">
            <div class="md:text-right">
                <livewire:project-types.project-type-create />
            </div>
        </div>
    </div>

    @if ($types->count() > 0)
    <!-- Resultados de la búsqueda y opciones de visualización -->
    <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
        Resultados
        <select name="perSearch" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>

    <!-- Tabla de Tipos de Proyectos -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-0">
                <div class="overflow-hidden border border-gray-300 dark:border-gray-700 shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-300">
                            <tr>
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

                                <th data-title="Ordenar por descripción" wire:click="order('description')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Descripción
                                    @if ($sortBy == 'description')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Estado
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($types as $type)
                            <tr wire:key="type-list-{{ $type->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $type->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $type->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $type->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    @if ($type->status == 'Activo')
                                    <span class="bg-green-100 px-2 py-1 rounded-md text-green-500">{{ $type->status
                                        }}</span>
                                    @else
                                    <span class="bg-red-200 px-2 py-1 rounded-md text-red-500">{{ $type->status
                                        }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <!-- Componentes de detalle, actualización y eliminación de categorías de proyectos -->
                                    <livewire:project-types.project-type-show :type='$type'
                                        wire:key='project-type-show-{{ $type->id}}' />


                                    <livewire:project-types.project-type-edit :typeId='$type->id'
                                        wire:key='project-type-edit-{{ $type->id}}' />


                                    <livewire:project-types.project-type-delete :type='$type'
                                        wire:key='project-type-delete-{{ $type->id}}' />

                                    {{-- <button wire:click="edittype({{ $type->id }})"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Editar</button>
                                    <button wire:click="deletetype({{ $type->id }})"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Eliminar</button>
                                    --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $types->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mensaje de no hay tipos -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    @endif
    @push('js')
    <script>
        // Notificación de creación de tipos de proyectos
        Livewire.on('createdProjectTypeNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Tipo de Proyecto Creado!'
                , text: 'El tipo de proyecto se ha creado correctamente!'
            })
        });

        // Notificación de edición de tipos de proyectos
        Livewire.on('updatedProjectTypeNotification', function(){
            swal.fire({
            icon:'success'
            , title: 'Tipo de Proyecto Actualizado!'
            , text: 'El tipo de proyecto se ha actualizado correctamente!'
            })
        });

        // Notificación de eliminación de tipos de proyectos
        Livewire.on('deletedProjectTypeNotification', function(){
            swal.fire({
                icon: 'success'
                , title: 'Tipo de Proyecto Eliminado!'
                , text: 'El tipo de proyecto se ha eliminado!'
          })
        });
    </script>
    @endpush
</div>
<div class="container mx-auto mt-8">

    {{-- <style>
        [data-title] {
            cursor: help;
            /* Cambia el cursor al puntero de ayuda */
        }

        th {
            position: relative;
            text-align: center;
        }

        th[data-title]::after {
            position: absolute;
            content: attr(data-title);
            bottom: -1.5em;
            left: 0;
            padding: 0.5em;
            background-color: #4e8ff8b1;
            color: #fff;
            font-size: 0.8em;
            border-radius: 0.25em;
            white-space: nowrap;
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        th:hover[data-title]::after {
            opacity: 1;
        }
    </style> --}}

    @if ($categories->count() > 0)

    <div class="grid items-center w-full md:grid-cols-12 mt-4">
        {{-- Barra de búsqueda --}}
        <div class="col-span-4 ml-4 shadow-md shadow-gray-500 border dark:border-blue-500 rounded-lg">
            <input type="text" name="search" wire:model.live="search"
                class="w-full bg-white dark:text-gray-100 dark:bg-gray-900 border-none rounded-lg focus:ring-blue-400"
                placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Categorías de Proyectos</h1>
            </div>
        </div>
        <div class="col-span-4 mt-4 md:mt-0 md:block md:col-span-4">
            <div class="md:text-right">
                <livewire:project-categories.project-category-create />
            </div>
        </div>
    </div>

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

    <!-- Tabla de Categorías de Proyectos -->
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
                            @foreach($categories as $category)
                            <tr wire:key="category-list-{{ $category->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $category->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    @if ($category->status == 'Activo')
                                    <span class="bg-green-100 px-2 py-1 rounded-md text-green-500">{{ $category->status
                                        }}</span>
                                    @else
                                    <span class="bg-red-200 px-2 py-1 rounded-md text-red-500">{{ $category->status
                                        }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <!-- Componentes de detalle, actualización y eliminación de categorías de proyectos -->
                                    <livewire:project-categories.project-category-show :category='$category'
                                        wire:key='project-category-show-{{ $category->id}}' />

                                    <livewire:project-categories.project-category-edit :categoryId='$category->id'
                                        wire:key='project-category-edit-{{ $category->id}}' />

                                    <livewire:project-categories.project-category-delete :category='$category->id'
                                        wire:key='project-category-delete-{{ $category->id}}' />

                                    {{-- <button wire:click="editCategory({{ $category->id }})"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Editar</button>
                                    <button wire:click="deleteCategory({{ $category->id }})"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Eliminar</button>
                                    --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mensaje de no hay categorías -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    @endif

    @push('js')
    <script>
        // Notificación de creación de categorías de proyectos
        Livewire.on('createdProjectCategoryNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Categoría de Proyecto Creada!'
                , text: 'La categoría de proyecto se ha creado correctamente!'
            })
        });

        // Notificación de edición de categorías de proyectos
        Livewire.on('updatedProjectCategoryNotification', function(){
            swal.fire({
            icon:'success'
            , title: 'Categoría de Proyecto Actualizada!'
            , text: 'La categoría de proyecto se ha actualizado correctamente!'
            })
        });

        // Notificación de eliminación de categorías de proyectos
        Livewire.on('deletedProjectCategoryNotification', function(){
            swal.fire({
                icon: 'success'
                , title: 'Categoría de Proyecto Eliminada!'
                , text: 'La categoría de proyecto se ha eliminado correctamente!'
          })
        });
    </script>
    @endpush
</div>
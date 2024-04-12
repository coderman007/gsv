<div class="container mx-auto mt-8">
    @if ($this->projectCategories->count() > 0)
        <section class="flex justify-between w-full mx-4">

            {{-- Barra de búsqueda --}}
            <div class="flex justify-start w-1/3">
                <x-input type="text" name="search" wire:model.live="search"
                         class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                         placeholder="Buscar..."/>
            </div>

            {{-- Título --}}
            <div class="flex justify-center w-1/3">
                <div class="text-xl font-bold text-center text-blue-400 uppercase">
                    <h1>Categorías de Proyectos</h1>
                </div>
            </div>

            {{-- Componente de creación --}}
            <div class="flex justify-end w-1/3 mr-8">
                <livewire:project-categories.project-category-create/>
            </div>
        </section>

        {{-- Opciones de visualización --}}
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
        <div class="relative hidden md:block mt-2 sm:mx-4 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-sm text-center text-gray-100 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 cursor-pointer" wire:click="order('id')">
                        ID
                        @if ($sortBy == 'id')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="py-3 cursor-pointer" wire:click="order('name')">
                        Correo
                        @if ($sortBy == 'name')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th
                        class="py-3 text-center text-sm font-semibold dark:text-gray-400 uppercase">
                        Descripción
                    </th>

                    <th
                        class="py-3 text-center text-sm font-semibold dark:text-gray-400 uppercase">
                        Estado
                    </th>

                    <th
                        class="py-3 pr-8 text-center text-sm font-semibold dark:text-gray-400 uppercase">
                        Acciones
                    </th>
                </tr>

                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($this->projectCategories as $category)
                    <tr wire:key="category-list-{{ $category->id }}"
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $category->id }}
                        </th>
                        <td class="">{{ $category->name }}</td>

                        <!-- Modificamos la parte de la tabla donde se muestra la descripción -->
                        <td class="">
                            @if (strlen($category->description) > 80)
                                @if ($showFullDescription === $category->id)
                                    {{ $category->description }}
                                    <button wire:click="toggleDescription({{ $category->id }})" class="text-blue-500 underline ml-2">
                                        <i class="fas fa-minus-circle"></i> <!-- Icono de FontAwesome para "Ver menos" -->
                                    </button>
                                @else
                                    {{ Str::limit($category->description, 80) }}
                                    <button wire:click="toggleDescription({{ $category->id }})" class="text-blue-500 underline ml-2">
                                        <i class="fas fa-plus-circle"></i> <!-- Icono de FontAwesome para "Ver más" -->
                                    </button>
                                @endif
                            @else
                                {{ $category->description }}
                            @endif
                        </td>

                        <td
                            class=" {{ $category->status === 'Activo' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $category->status }}
                        </td>

                        <!-- Componentes de detalle, actualización y eliminación de categorías de proyectos -->
                        <td class="text-center pr-8">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:project-categories.project-category-show :category='$category'
                                                                                   wire:key='project-category-show-{{ $category->id}}'/>
                                <livewire:project-categories.project-category-edit :categoryId='$category->id'
                                                                                   wire:key='project-category-edit-{{ $category->id}}'/>
                                <livewire:project-categories.project-category-delete :category='$category->id'
                                                                                     wire:key='project-category-delete-{{ $category->id}}'/>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                            No hay Categorías de Proyectos Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="px-3 py-1">
                {{ $this->projectCategories->links() }}
            </div>
        </div>

    @else
        <!-- Mensaje de no hay categorías -->
        <h1 class="my-64 text-5xl text-center dark:text-gray-200">
            <div>¡Ups!</div>
            <br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
        </h1>

        <div class="flex justify-center w-full h-auto">
            <livewire:project-categories.project-category-create/>
            <button
                class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
                <a href="{{ route('project-categories') }}">Volver</a>
            </button>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de categorías de proyectos
            Livewire.on('createdProjectCategoryNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Categoría de Proyecto Creada!'
                    , text: 'La categoría de proyecto se ha creado correctamente!'
                })
            });

            // Notificación de edición de categorías de proyectos
            Livewire.on('updatedProjectCategoryNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Categoría de Proyecto Actualizada!'
                    , text: 'La categoría de proyecto se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de categorías de proyectos
            Livewire.on('deletedProjectCategoryNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Categoría de Proyecto Eliminada!'
                    , text: 'La categoría de proyecto se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

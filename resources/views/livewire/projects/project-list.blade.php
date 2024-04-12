<div class="container mx-auto mt-8">
    @if ($this->projects->count() > 0)
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
                    <h2>APU's</h2>
                </div>
            </div>

            {{-- Componente de creación --}}
            <div class="flex justify-end w-1/3 mr-8">
                <livewire:projects.project-create/>
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('project_category_id')">
                        Categoría
                        @if ($sortBy == 'project_category_id')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>


                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('name')">
                        Nombre APU
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('description')">
                        Descripción
                        @if ($sortBy == 'description')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Kilowatts a Proveer
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse ($this->projects as $project)
                    <tr
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $project->id }}
                        </th>

                        <td class="px-6 py-4 dark:text-lg">{{ $project->projectCategory->name }}</td>


                        <td class="px-6 py-4 dark:text-lg">{{ $project->name }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $project->description }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $project->kilowatts_to_provide }}</td>
                        <td
                            class="px-6 py-4 dark:text-lg {{ $project->status === 'Activo' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $project->status }}
                        </td>

                        <td class="flex justify-around py-4 pl-2 pr-8 ml-6">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:projects.project-show :project='$project'
                                                                wire:key='project-show-{{ $project->id}}'/>
                                <livewire:projects.project-edit :project='$project->id'
                                                                wire:key='project-edit-{{ $project->id}}'/>
                                <livewire:projects.project-delete :project='$project->id'
                                                                  wire:key='project-delete-{{ $project->id}}'/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                            No hay APU's Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="px-3 py-1">
                {{ $this->projects->links() }}
            </div>
        </div>
    @else
        <!-- Mensaje de no hay categorías -->
        <h1 class="my-64 text-5xl text-center dark:text-gray-200">
            <div>¡Ups!</div>
            <br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
        </h1>

        <div class="flex justify-center w-full h-auto">
            <livewire:projects.project-create/>
            <button
                class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
                <a href="{{ route('projects') }}">Volver</a>
            </button>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de categorías de proyectos
            Livewire.on('createdProjectNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Proyecto Creado!'
                    , text: 'El proyecto se ha creado correctamente!'
                })
            });

            // Notificación de edición de categorías de proyectos
            Livewire.on('updatedProjectNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Proyecto Actualizado!'
                    , text: 'El proyecto se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de categorías de proyectos
            Livewire.on('deletedProjectNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Proyecto Eliminado!'
                    , text: 'El proyecto se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

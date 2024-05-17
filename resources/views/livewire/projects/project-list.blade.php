<div class="container mx-auto mt-8">
    @if ($this->projects->count() > 0)
        <section class="flex justify-between w-full mx-4">
            <div class="flex justify-start w-1/3">
                <div class="flex flex-col">
                    {{-- Barra de búsqueda --}}
                    <x-input type="text" name="search" wire:model.lazy="search"
                             class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                             placeholder="Buscar..."/>

                    {{-- Selector de categorías --}}
                    <div class="flex justify-start w-full mt-2">
                        <select wire:model.lazy="selectedCategory"
                                class="w-full bg-white text-gray-500 dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
            <select name="perPage" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>

        <!-- Tabla de Proyectos -->
        <div class="relative hidden md:block mt-2 sm:mx-4 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-sm text-center text-gray-100 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('kilowatts_to_provide')">
                        Potencia
                        @if ($sortBy == 'kilowatts_to_provide')
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
                        Zona
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
                @forelse ($projects as $project)
                    <tr class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" wire:key="project-{{ $project->id }}">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $project->id }}
                        </th>

                        <td class="px-6 py-4 dark:text-lg">{{ $project->projectCategory->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $project->kilowatts_to_provide . " Kwh" }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $project->zone }}</td>
                        <td class="px-6 py-4 dark:text-lg {{ $project->status === 'Activo' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $project->status }}
                        </td>

                        <td class="flex justify-around py-4 pl-2 pr-8 ml-6">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:projects.project-show :project='$project' wire:key='project-show-{{ $project->id }}'/>
                                <livewire:projects.project-edit :project='$project->id' wire:key='project-edit-{{ $project->id }}'/>
                                <livewire:projects.project-delete :project='$project->id' wire:key='project-delete-{{ $project->id }}'/>
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
        <div class="flex justify-end m-4 p-4">
            <livewire:projects.project-create/>
        </div>

        <!-- Mensaje de no hay proyectos -->
        <h2 class="my-32 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h2>

        <div class="flex justify-center w-full h-auto">
            <a href="{{ route('projects') }}">
                <x-gray-button>
                    Volver
                </x-gray-button>
            </a>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de categorías de proyectos

            Livewire.on('createdProjectNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'APU Creado!',
                    text: 'El APU se ha creado correctamente!'
                });
            });

            // Notificación de edición de categorías de proyectos
            Livewire.on('updatedProjectNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'APU Actualizado!',
                    text: 'El APU se ha actualizado correctamente!'
                });
            });

            // Notificación de eliminación de categorías de proyectos
            Livewire.on('deletedProjectNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'APU Eliminado!',
                    text: 'El APU se ha eliminado correctamente!'
                });
            });
        </script>
    @endpush
</div>

<div>
    @if ($this->projects->count() > 0)
        <div class="grid items-center w-full md:grid-cols-12 mt-2">
            {{-- Barra de búsqueda --}}
            <div class="col-span-4">
                <x-input type="text" name="search" wire:model.live="search"
                    class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                    placeholder="Buscar..." />
            </div>
            <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
                <div class="text-xl font-bold text-center text-blue-400 uppercase">
                    <h1>Proyectos</h1>
                </div>
            </div>
            <div class="inline mt-4 md:mt-0 md:block md:col-span-4">
                <livewire:projects.project-create />
            </div>
        </div>
        <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
            Resultados
            <select name="perPage" id="perPage" wire:model.live="perPage" class="rounded-lg cursor-pointer">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="relative hidden md:block sm:mx-4 mt-2 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-sm text-center text-gray-100 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('id')">
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

                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('name')">
                            Nombre Proyecto
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

                            <td class="px-6 py-4 dark:text-lg">{{ $project->name }}</td>
                            <td class="px-6 py-4 dark:text-lg">{{ $project->description }}</td>
                            <td class="px-6 py-4 dark:text-lg">{{ $project->kilowatts_to_provide }}</td>
                            <td
                                class="px-6 py-4 dark:text-lg {{ $project->status === 'Activo' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $project->status }}
                            </td>
                           
                            <td class="flex justify-around py-4 pl-2 pr-8">
                                <div class="flex">
                                    {{-- <livewire:projects.project-show :project='$project' :key='$project->id' />
                                    <livewire:projects.project-edit :project='$project' :key='$project->id' />
                                    <livewire:projects.project-delete :project='$project' :key='$project->id' /> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-3xl text-center dark:text-gray-200">
                                No hay cotizaciones disponibles
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
        <!-- Mensaje de no hay proyectos -->
        <h1 class="my-64 text-5xl text-center dark:text-gray-200">
            <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
        </h1>
        <div class="flex justify-center w-full h-auto">
            <livewire:projects.project-create />
            <button
                class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
                <a href="{{ route('projects') }}">Volver</a>
            </button>
        </div>
    @endif

</div>

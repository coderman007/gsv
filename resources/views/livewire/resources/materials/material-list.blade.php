<div class="container mx-auto mt-8">
    @if ($this->materials->count() > 0)
    <section class="flex justify-between w-full mx-4">

        {{-- Barra de búsqueda --}}
        <div class="flex justify-start w-1/3">
            <x-input type="text" name="search" wire:model.lazy="search"
                     class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                     placeholder="Buscar..."/>
        </div>

        {{-- Título --}}
        <div class="flex justify-center items-center w-1/3">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Materiales</h1>
            </div>
        </div>

        {{-- Componente de creación --}}
        <div class="flex justify-end w-1/3 mr-8">
            <livewire:resources.materials.material-create/>
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

        <!-- Tabla de Materiales -->
        <div class="relative hidden md:block mt-2 sm:mx-4 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('reference')">
                        Referencia
                        @if ($sortBy == 'reference')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('rated_power')">
                        Potencia Nominal
                        @if ($sortBy == 'rated_power')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('unit_price')">
                        Precio Unitario
                        @if ($sortBy == 'unit_price')
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
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->materials as $material)
                    <tr wire:key="material-{{ $material->id }}"
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $material->id }}
                        </th>
                        <td class="flex justify-start px-6 py-4 dark:text-lg">
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover mt-1"
                                     src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->reference }}" />
                            </button>
                            <span class="ml-8 mt-3">{{ $material->reference }}</span>
                        </td>
                        <td class="px-6 py-4 dark:text-lg">{{ $material->rated_power }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $material->unit_price }}</td>

                        <td class="flex justify-around py-4 pl-2 pr-8 ml-6">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:resources.materials.material-show :material="$material"
                                                                            :key="time() . $material->id"/>
                                <livewire:resources.materials.material-edit :materialId="$material->id"
                                                                            :key="time() . $material->id"/>

                                <livewire:resources.materials.material-delete :material="$material"
                                                                              :key="time() . $material->id"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                            No hay Materiales Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="px-3 py-1">
                {{ $this->materials->links() }}
            </div>
        </div>
    @else
        <div class="flex justify-end m-4 p-4">
            <livewire:resources.materials.material-create/>
        </div>

        <!-- Mensaje de no hay proyectos -->
        <h2 class="my-32 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h2>

        <div class="flex justify-center w-full h-auto">
            <a href="{{ route('materials') }}">
                <x-gray-button>
                    Volver
                </x-gray-button>
            </a>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de materiales
            Livewire.on('createdMaterialNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Material Creado!',
                    text: 'El material se ha creado correctamente!'
                })
            });

            // Notificación de edición de materiales
            Livewire.on('updatedMaterialNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Material Actualizado!',
                    text: 'El material se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de materiales
            Livewire.on('deletedMaterialNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Material Eliminado!',
                    text: 'El material se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

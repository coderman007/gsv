<div class="container mx-auto mt-8">
    @if ($this->clients->count() > 0)
        <section class="flex justify-between w-full mx-4">

            {{-- Barra de búsqueda --}}
            <div class="flex justify-start w-1/3">
                <x-input type="text" name="search" wire:model.lazy="search"
                         class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                         placeholder="Buscar..."/>
            </div>

            {{-- Título --}}
            <div class="flex justify-center w-1/3">
                <div class="text-xl font-bold text-center text-blue-400 uppercase">
                    <h1>Clientes</h1>
                </div>
            </div>

            {{-- Componente de creación --}}
            <div class="flex justify-end w-1/3 mr-8">
                <livewire:clients.client-create/>
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

        <!-- Tabla de Clientes -->
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('type')">
                        Tipo
                        @if ($sortBy == 'type')
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
                        Nombre
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('document')">
                        NIT/Documento
                        @if ($sortBy == 'document')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('email')">
                        Correo
                        @if ($sortBy == 'email')
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
                        Dirección
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Teléfono
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->clients as $client)
                    <tr wire:key="client-{{ $client->id }}"
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $client->id }}
                        </th>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->type }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->name }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->document }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->email }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->address }}</td>
                        <td class="px-6 py-4 dark:text-lg">{{ $client->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($client->status == 'Activo')
                                <span class="bg-green-100 px-2 py-1 rounded-md text-green-500">{{ $client->status
                                        }}</span>
                            @else
                                <span class="bg-red-200 px-2 py-1 rounded-md text-red-500">{{ $client->status
                                        }}</span>
                            @endif
                        </td>

                        <td class="flex justify-around py-4 pl-2 pr-8">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:clients.client-show :client="$client" :key="time() . $client->id"/>
                                <livewire:clients.client-edit :client="$client" :key="time() . $client->id"/>
                                <livewire:clients.client-delete :client="$client" :key="time() . $client->id"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    @if($search)
                        <tr>
                            <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                                No se encontraron coincidencias en la búsqueda.
                            </td>
                        </tr>
                    @else
                        <!-- No hay registros en la base de datos -->
                        <tr>
                            <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                                Aún no hay registros de clientes.
                            </td>
                        </tr>
                    @endif
                @endforelse
                </tbody>
            </table>

            <div class="px-3 py-1">
                {{ $this->clients->links() }}
            </div>
        </div>
    @else
        <div class="flex justify-end m-4 p-4">
            <livewire:clients.client-create/>
        </div>

        <!-- Mensaje de no hay clientes -->
        <h2 class="my-32 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h2>

        <div class="flex justify-center w-full h-auto">
            <a href="{{ route('clients') }}">
                <x-gray-button>
                    Volver
                </x-gray-button>
            </a>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de clientes
            Livewire.on('createdClientNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cliente Creado!',
                    text: 'El cliente se ha creado correctamente!'
                })
            });

            // Notificación de edición de clientes
            Livewire.on('updatedClientNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cliente Actualizado!',
                    text: 'El cliente se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de clientes
            Livewire.on('deletedClientNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cliente Eliminado!',
                    text: 'El cliente se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

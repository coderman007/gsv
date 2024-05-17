<div class="container mx-auto mt-8">
    @if($users->count() > 0)
        <section class="flex justify-between w-full mx-4">

            {{-- Barra de búsqueda --}}
            <div class="flex justify-start w-1/3">
                <x-input type="text" name="search" wire:model.lazy="search"
                         class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                         placeholder="Buscar..."/>
            </div>

            {{-- Título --}}
            <div class="flex justify-center w-1/3">
                <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                    <h1>Usuarios</h1>
                </div>
            </div>

            {{-- Componente de creación --}}
            <div class="flex justify-end w-1/3 mr-8">
                <livewire:users.user-create/>
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

        <!-- Tabla de Usuarios -->
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('email')">
                        Correo Electrónico
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('email')">
                        Rol
                        @if ($sortBy == 'roles.name')
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
                        Estado
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $user)
                    <tr wire:key="user-list-{{ $user->id }}"
                        class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                        <td class="px-6 text-center py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="flex justify-start px-6 py-4 whitespace-nowrap">
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover"
                                     src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"/>
                            </button>
                            <span class="ml-2">{{ $user->name }}</span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $user->email }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $user->roles->first()->name ??
                                    'Sin Rol' }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($user->status == 'Activo')
                                <span class="bg-green-100 px-2 py-1 rounded-md text-green-500">{{ $user->status
                                        }}</span>
                            @else
                                <span class="bg-red-200 px-2 py-1 rounded-md text-red-500">{{ $user->status
                                        }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:users.user-show :user='$user' wire:key='user-show{{ $user->id}}'/>
                                <livewire:users.user-edit :userId='$user->id'
                                                          wire:key='user-edit-{{ $user->id}}'/>
                                <livewire:users.user-delete :user='$user'
                                                            wire:key='user-delete-{{ $user->id}}'/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                            No hay Posiciones Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="px-3 py-1">
                {{ $users->links() }}
            </div>
        </div>
    @else
        <div class="flex justify-end m-4 p-4">
            <livewire:users.user-create/>
        </div>

        <!-- Mensaje de no hay usuarios -->
        <h2 class="my-32 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h2>

        <div class="flex justify-center w-full h-auto">
            <a href="{{ route('users') }}">
                <x-gray-button>
                    Volver
                </x-gray-button>
            </a>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de usuarios
            Livewire.on('createdUserNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Usuario Creado!'
                    , text: 'El usuario se ha creado correctamente!'
                })
            });

            // Notificación de edición de usuarios
            Livewire.on('updatedUserNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Usuario Actualizado!'
                    , text: 'El usuario se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de usuarios
            Livewire.on('deletedUserNotification', function () {
                swal.fire({
                    icon: 'success'
                    , title: 'Usuario Eliminado!'
                    , text: 'El usuario se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush

</div>

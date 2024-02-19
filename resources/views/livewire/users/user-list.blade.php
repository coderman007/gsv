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

    @if ($users->count() > 0)

    <div class="grid items-center w-full md:grid-cols-12 mt-4">
        {{-- Barra de búsqueda --}}
        <div class="col-span-4 ml-4 shadow-md shadow-gray-500 border dark:border-blue-500 rounded-lg">
            <input type="text" name="search" wire:model.live="search"
                class="w-full bg-white dark:text-gray-100 dark:bg-gray-900 border-none rounded-lg focus:ring-blue-400"
                placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Usuarios</span></h1>
            </div>
        </div>
        <div class="col-span-4 mt-4 md:mt-0 md:block md:col-span-4">
            <div class="md:text-right">
                <livewire:users.user-create />
            </div>
        </div>
    </div>
    <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
        Resultados
        <select name="perSearch" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>
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

                                <th data-title="Ordenar por correo electrónico" wire:click="order('email')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Correo Electrónico
                                    @if ($sortBy == 'email')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Rol" wire:click="order('roles.name')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Rol
                                    @if ($sortBy == 'roles.name')
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
                            @foreach($users as $user)
                            <tr wire:key="user-list-{{ $user->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $user->id }}</td>
                                <td class="flex justify-start px-6 py-4 whitespace-nowrap">
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                    </button>
                                    <span class="ml-2">{{ $user->name }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-left">{{ $user->email }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-left">{{ $user->roles->first()->name ??
                                    'Sin Rol' }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    @if ($user->status == 'Activo')
                                    <span class="bg-green-100 px-2 py-1 rounded-md text-green-500">{{ $user->status
                                        }}</span>
                                    @else
                                    <span class="bg-red-200 px-2 py-1 rounded-md text-red-500">{{ $user->status
                                        }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <livewire:users.user-show :user='$user' wire:key='user-show{{ $user->id}}' />
                                    <livewire:users.user-edit :userId='$user->id' wire:key='user-edit-{{ $user->id}}' />
                                    <livewire:users.user-delete :user='$user' wire:key='user-delete-{{ $user->id}}' />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mensaje de no hay usuarios -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    <div class="flex justify-center w-full h-auto">
        <button
            class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
            <a href="{{ route('users') }}">Volver</a>
        </button>
    </div>
    @endif
    @push('js')
    <script>
        // Notificación de creación de usuarios
        Livewire.on('createdUserNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Usuario Creado!'
                , text: 'El usuario se ha creado correctamente!'
            })
        });

        // Notificación de edición de usuarios
        Livewire.on('updatedUserNotification', function(){
            swal.fire({
            icon:'success'
            , title: 'Usuario Actualizado!'
            , text: 'El usuario se ha actualizado correctamente!'
            })
        });

        // Notificación de eliminación de usuarios
        Livewire.on('deletedUserNotification', function(){
            swal.fire({
                icon: 'success'
                , title: 'Usuario Eliminado!'
                , text: 'El usuario se ha eliminado correctamente!'
          })
        });
    </script>
    @endpush

</div>
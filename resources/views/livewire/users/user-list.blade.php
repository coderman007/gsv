<div>
    @if ($this->users->count() > 0)

    <div class="grid items-center w-full md:grid-cols-12 mt-2">
        {{-- Barra de búsqueda --}}
        <div class="col-span-4">
            <x-input type="text" name="search" wire:model.live="search" class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400" placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-xl font-bold text-center text-blue-400 uppercase">
                <h1>Usuarios</span></h1>
            </div>

        </div>
        <div class="inline mt-4 md:mt-0 md:block md:col-span-4">
            <livewire:users.user-create />
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

    <div class="relative hidden md:block mt-2 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-center text-gray-100 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-1 py-4 cursor-pointer">
                        ID
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer">
                        Nombre
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer">
                        Correo
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
                @forelse ($this->users as $user)
                <div class="hidden">
                    @if ($user->status === 'Activo')
                    {{ $colorStatus = 'text-green-600' }}
                    @else
                    {{ $colorStatus = 'text-red-500' }}
                    @endif
                </div>
                <tr class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $user->id }}
                    </th>
                    <td class="px-6 py-4 dark:text-lg">{{ $user->name }}</td>
                    <td class="px-6 py-4 ">{{ $user->email }}</td>
                    <td class="px-6 py-4 dark:text-lg {{ $colorStatus }}">{{ $user->status }}</td>
                    <td class="flex justify-around py-4 pl-2 pr-8">
                        <div class="flex">
                            <livewire:users.user-show :user="$user" :key="time() . $user->id" />
                            <livewire:users.user-edit :user="$user" :key="time() . $user->id" />
                            <livewire:users.user-delete :user="$user" :key="time() . $user->id" />
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                        No hay usuarios Disponibles
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-3 py-1">
            {{ $this->users->links() }}
        </div>
    </div>
    @else
    <!-- Mensaje de no hay usuarios -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    <div class="flex justify-center w-full h-auto">
        <button class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
            <a href="{{ route('users') }}">Volver</a>
        </button>
    </div>
    @endif
</div>

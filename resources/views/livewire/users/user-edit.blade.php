<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-edit"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal wire:model="openEdit">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-100 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="text-center mt-6">
                        <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Editar Información del Usuario</h2>
                    </div>
                    <form wire:submit.prevent="updateUser">
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <!-- Dropdown para Rol -->
                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Tipo de Usuario</h1>
                                <select wire:model="selectedRole"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" >
                                    <option value="" disabled>Selecciona un Tipo</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $role->name ==
                                            $user->getRoleNames()->first() ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="selectedRole" />
                            </div>
                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Nombre</h1>
                                <input wire:model="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" />
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Correo Electrónico</h1>
                                <input wire:model="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" />
                                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Dropdown para Estado -->
                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Estado</h1>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
                                    wire:model="status">
                                    <option value="" disabled>Selecciona un estado</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                                <x-input-error for="status" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mt-5 flex justify-end gap-4">
                <button type="button" wire:click="closeModal"
                        class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition duration-300 transform active:scale-95 ease-in-out">
            <span class="mx-1">
                <svg class="w-5 h-5 mr-2 font-extrabold" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </span>
                    Salir
                </button>
                <button type="submit" wire:click="updateUser"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                    Actualizar Usuario
                </button>
            </div>
        </x-slot>

    </x-dialog-modal>
</div>

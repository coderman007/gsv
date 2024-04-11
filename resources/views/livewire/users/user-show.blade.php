<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal wire:model="openShow">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-100 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="text-center mt-6">
                        <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información del Usuario</h2>
                    </div>
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <div class="mb-4">
                                <div class="mx-auto my-2 rounded-full w-48 overflow-hidden border-2 border-gray-950">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                     class="w-full h-auto rounded-lg">
                                </div>
                            </div>

                            <div class="pt-24">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Tipo de Usuario</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $role->name }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">
                                    Nombre</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $user->name }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">
                                    Correo Electrónico</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $user->email }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Estado</h1>
                            @if ($user->status == 'Activo')
                                <p class="p-2 text-green-500 rounded-md text-lg text-center uppercase">{{ $user->status }}</p>
                            @else
                                <p class="p-2 text-red-400 rounded-md text-lg text-center uppercase">{{ $user->status }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mx-auto">
                <div class="px-6">
                    <div class="mx-auto">
                        <button wire:click="$set('openShow', false)"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold py-2 px-6 rounded-md">
                            Salir
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

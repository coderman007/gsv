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

    <x-dialog-modal wire:model="openShow" maxWidth="3xl">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="text-center mt-6">
                        <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información del Cliente</h2>
                    </div>
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <div class="mb-4">
                                <div class="mx-auto my-2 rounded-lg w-72 overflow-hidden">
                                    <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}"
                                         class="w-full h-auto rounded-lg">
                                </div>
                            </div>
                            <div class="pt-24">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Tipo de Cliente</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->type }}</p>
                            </div>
                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">
                                    {{ $client->type == 'Empresa' ? 'Nombre de Empresa' : 'Nombre' }}</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->name }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">
                                    {{ $client->type == 'Empresa' ? 'NIT' : 'Documento' }}</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->document }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Correo Electrónico
                                </h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->email }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Dirección</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->address }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Teléfono</h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $client->phone }}</p>
                            </div>

                            <div class="mb-4">
                                <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Estado</h1>
                                @if ($client->status == 'Activo')
                                    <p class="text-lg py-2 text-green-500 dark:text-green-600 rounded-md">
                                        {{ $client->status }}</p>
                                @else
                                    <p class="text-lg py-2 text-red-500 dark:text-red-600 rounded-md">
                                        {{ $client->status }}</p>
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

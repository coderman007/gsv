<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openShow" maxWidth="4xl">
        <x-slot name="title">
            <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información de
                Proyecto</h2>
        </x-slot>

        <x-slot name="content">
            <div class="w-full h-auto bg-white dark:bg-gray-800">
                <div>
                    <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Nombre</h1>
                    <p class="text-lg text-gray-800 dark:text-white">{{ $project->name }}</p>
                </div>

                <div>
                    <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Descripción</h1>
                    <p class="text-lg text-gray-800 dark:text-white">{{ $project->description }}</p>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 px-4 py-4 gap-x-4 gap-y-8">
                        <div class="sm:col-span-1 md:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->projectCategory->name }}</dd>
                        </div>
                        <div class="sm:col-span-1 md:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kilowatts a proporcionar</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $project->kilowatts_to_provide }}</dd>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Estado</h1>
                            @if ($project->status == 'Activo')
                                <p class="text-lg py-2 text-green-500 dark:text-green-600 rounded-md">
                                    {{ $project->status }}</p>
                            @else
                                <p class="text-lg py-2 text-red-500 dark:text-red-600 rounded-md">
                                    {{ $project->status }}</p>
                            @endif
                        </div>
                    </dl>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="mx-auto px-6">
                <button wire:click="$set('openShow', false)"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold py-2 px-6 rounded-md">
                    Salir
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

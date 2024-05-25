<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"></svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openShow" maxWidth="4xl">
        <x-slot name="title">
            <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información de APU</h2>
        </x-slot>

        <x-slot name="content">
            <div class="w-full bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-300 mb-2">{{ $project->name }}</h1>
                    <p class="text-lg text-gray-800 dark:text-white mb-6">{{ $project->description }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="rounded-lg bg-gray-100 dark:bg-gray-700 p-4">
                            <h1 class="text-lg font-bold text-gray-900 dark:text-gray-300">Categoría</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $project->projectCategory->name }}</p>
                        </div>
                        <div class="rounded-lg bg-gray-100 dark:bg-gray-700 p-4">
                            <h1 class="text-lg font-bold text-gray-900 dark:text-gray-300">Potencia</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $project->power_output }}</p>
                        </div>
                        <div class="rounded-lg bg-gray-100 dark:bg-gray-700 p-4">
                            <h1 class="text-lg font-bold text-gray-900 dark:text-gray-300">Estado</h1>
                            @if ($project->status == 'Activo')
                                <p class="text-lg py-2 text-green-500 dark:text-green-600">{{ $project->status }}</p>
                            @else
                                <p class="text-lg py-2 text-red-500 dark:text-red-600">{{ $project->status }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mx-auto px-6">
                <button wire:click="$set('openShow', false)" class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold py-2 px-6 rounded-md">
                    Salir
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

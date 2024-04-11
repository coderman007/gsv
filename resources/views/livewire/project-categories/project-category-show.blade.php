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

    <x-dialog-modal wire:model="openShow" maxWidth="5xl">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="text-center mt-6">
                        <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información de la Categoría de Proyecto</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 px-6">
                        <div>
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Nombre</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $category->name }}</p>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Descripción</h1>
                            <div class="text-lg text-gray-800 dark:text-white" style="overflow-wrap: break-word; text-align: justify;">
                                {!! $this->formatDescription($category->description) !!}
                            </div>
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

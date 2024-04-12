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
            <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Información de la Categoría de
                Proyecto</h2>
        </x-slot>

        <x-slot name="content">
            <div class="w-full h-auto bg-white dark:bg-gray-800">
                <div class="grid grid-cols-2 gap-4 p-6">
                    <div class="col-span-2 mb-4 flex justify-center">
                        <div class="mx-auto rounded-lg overflow-hidden border-2 border-blue-500">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 class="w-72 h-auto rounded-lg">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Nombre</h1>
                        <p class="text-lg text-gray-800 dark:text-white">{{ $category->name }}</p>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Estado</h1>
                        @if ($category->status == 'Activo')
                            <p class="text-lg py-2 text-green-500 dark:text-green-600 rounded-md">
                                {{ $category->status }}</p>
                        @else
                            <p class="text-lg py-2 text-red-500 dark:text-red-600 rounded-md">
                                {{ $category->status }}</p>
                        @endif
                    </div>
                    <div class="col-span-2">
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Descripción</h1>
                        <div class="text-lg text-gray-800 dark:text-white pl-4"
                             style="overflow-wrap: break-word; text-align: justify;">
                            {{ $category->description }}
                        </div>
                    </div>
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

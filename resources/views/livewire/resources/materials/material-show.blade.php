<!-- resources/views/livewire/resources/materials/additional-show.blade.php -->

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
            <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Detalle del Material</h2>
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="grid grid-cols-2 gap-4 p-4">
                        <div class="mb-4">
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Imagen</h1>
                            <div class="mx-auto my-2 rounded-lg w-72 overflow-hidden">
                                <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->reference }}"
                                     class="w-full h-auto rounded-lg">
                            </div>
                        </div>
                        <div class="col-span-1 mb-4">
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Categoría</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $material->materialCategory->name }}</p>
                        </div>

                        <div class="col-span-2 mb-4">
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Referencia</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $material->reference }}</p>
                        </div>

                        <div class="col-span-2 mb-4">
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Descripción</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $material->description }}</p>
                        </div>

                        <div class="col-span-2 mb-4">
                            <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Precio Unitario</h1>
                            <p class="text-lg text-gray-800 dark:text-white">{{ $material->unit_price }}</p>
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

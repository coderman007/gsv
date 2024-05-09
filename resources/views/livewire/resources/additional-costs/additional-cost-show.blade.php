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
    <x-dialog-modal wire:model="openShow" maxWidth="2xl">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Detalle del Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <div class="grid grid-cols-2 gap-4 bg-gray-100 rounded-lg p-10">
                    <div class="col-span-2 mb-4">
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Nombre</h1>
                        <p class="text-lg text-gray-800 dark:text-white">{{ $additionalCost->name }}</p>
                    </div>

                    <div class="col-span-2 mb-4">
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Descripción</h1>
                        <p class="text-lg text-gray-800 dark:text-white">{{ $additionalCost->description }}</p>
                    </div>

                    <div class="col-span-2 mb-4">
                        <h1 class="text-lg font-bold text-gray-950 dark:text-gray-400">Precio Unitario</h1>
                        <p class="text-lg text-gray-800 dark:text-white">{{ $additionalCost->unit_price }}</p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <button wire:click="$set('openShow', false)"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Salir
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

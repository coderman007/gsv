<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <i class="p-1 text-green-400 rounded hover:text-white hover:bg-green-500 fas fa-eye"></i>
        <div
            class="absolute z-10 px-3 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openShow">
        <x-slot name="title">
            <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Detalles de la Cotización</h2>
        </x-slot>

        <x-slot name="content">
            <div class="flex justify-center items-center w-full h-full bg-white dark:bg-gray-800">
                <div class="w-full bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                    <div class="text-center mt-6">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Detalles de la Cotización
                        </h2>
                    </div>
                    <div class="px-6 py-8">
                        <!-- Contenido del detalle de la cotización -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <h1 class="text-md font-semibold text-gray-600 dark:text-gray-400">Fecha de Cotización
                                </h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $quotation->quotation_date }}</p>
                            </div>
                            <div class="mb-4">
                                <h1 class="text-md font-semibold text-gray-600 dark:text-gray-400">Período de Validez
                                </h1>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $quotation->validity_period }}</p>
                            </div>
                            <!-- Agrega más detalles de la cotización aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="mx-auto">
                <div class="px-6 py-4">
                    <div class="mx-auto">
                        <button wire:click="$set('openShow', false)"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold py-3 px-6 rounded-md">
                            Salir
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

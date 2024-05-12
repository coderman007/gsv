<div class="relative inline-block text-left cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal maxWidth="2xl" wire:model="openEdit">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-2xl font-semibold text-center text-blue-400 dark:text-white">Editar Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="updateAdditional" class="space-y-5 max-w-sm mx-auto bg-gray-100 p-10 rounded-lg">

                    <!-- Campo para el nombre -->
                    <div class="mb-5">
                        <label for="name"
                               class="inline-block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre:</label>
                        <input wire:model="name" type="text" id="name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Ingrese el nombre" required/>
                        <x-input-error for="name"/>
                    </div>

                    <!-- Campo para la descripción -->
                    <div class="mb-5">
                        <label for="description" class="inline-block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción:</label>
                        <textarea wire:model="description" id="description"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="Ingrese la descripción" required></textarea>
                        <x-input-error for="description"/>
                    </div>

                    <!-- Campo para el valor -->
                    <div class="mb-5">
                        <label for="unit_price" class="inline-block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor:</label>
                        <input wire:model="unitPrice" type="number" id="unit_price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Ingrese el valor" required/>
                        <x-input-error for="unit_price"/>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="updateAdditional"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Actualizar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

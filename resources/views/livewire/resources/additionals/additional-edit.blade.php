<div>
    <!-- Botón para abrir el diálogo de edición -->
    <div class="relative inline-block text-center cursor-pointer group">
        <a href="#" wire:click="$set('openEdit', true)">
            <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
                <i class="fa fa-solid fa-pen-to-square"></i>
            </div>
            <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
                Editar
                <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                </svg>
            </div>
        </a>
    </div>

    <!-- Diálogo modal para editar un adicional -->
    <x-dialog-modal maxWidth="3xl" wire:model="openEdit">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-2xl font-semibold text-center text-gray-500 dark:text-white py-6">Editar Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <div class="border border-yellow-500 shadow-sm shadow-yellow-500 m-4 p-10 rounded-lg">
                    <form class="space-y-5 mx-auto">

                        <!-- Campo para el nombre -->
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-left text-sm font-medium text-gray-500 dark:text-white">Nombre:</label>
                            <input wire:model="name" type="text" id="name"
                                   class="bg-yellow-50 border border-yellow-300 text-gray-500 text-sm rounded-lg focus:ring-yellow-300 focus:border-yellow-300 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Ingrese el nombre" required/>
                            <x-input-error for="name"/>
                        </div>

                        <!-- Campo para la descripción -->
                        <div class="mb-5">
                            <label for="description" class="block mb-2 text-left text-sm font-medium text-gray-500 dark:text-white">Descripción:</label>
                            <textarea wire:model="description" id="description"
                                      class="bg-yellow-50 border border-yellow-300 text-gray-500 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Ingrese la descripción" required></textarea>
                            <x-input-error for="description"/>
                        </div>

                        <!-- Campo para el valor -->
                        <div class="mb-5">
                            <label for="unit_price" class="block mb-2 text-sm text-left font-medium text-gray-500 dark:text-white">Valor:</label>
                            <input wire:model="unitPrice" type="number" step=100 id="unit_price"
                                   class="bg-yellow-50 border border-yellow-300 text-gray-500 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Ingrese el valor" required/>
                            <x-input-error for="unit_price"/>
                        </div>

                    </form>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-between gap-4 text-lg">
                    <button type="button" wire:click="$set('openEdit', false)"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fa-solid fa-ban mr-2"></i> Cancelar
                    </button>
                    <button type="submit" wire:click="updateAdditional"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fa-solid fa-pen-to-square mr-2 text-xl"></i> Actualizar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

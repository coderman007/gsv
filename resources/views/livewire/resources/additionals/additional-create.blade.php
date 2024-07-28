<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <div class="flex items-center">
                <i class="fa fa-solid fa-cart-plus mr-2 text-xl"></i> Nuevo Adicional
            </div>
        </span>
    </button>
    <x-dialog-modal maxWidth="3xl" wire:model="openCreate">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-2xl font-semibold text-center text-gray-500 dark:text-white py-6">Crear Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <div class="border border-yellow-500 shadow-sm shadow-yellow-500 m-4 p-10 rounded-lg">
                    <form class="space-y-5 mx-auto">

                        <!-- Campo para el nombre -->
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Nombre:</label>
                            <input wire:model="name" type="text" id="name"
                                   class="bg-yellow-50 border border-yellow-300 text-gray-500 text-sm rounded-lg focus:ring-yellow-300 focus:border-yellow-300 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Ingrese el nombre" required/>
                            <x-input-error for="name"/>
                        </div>

                        <!-- Campo para la descripción -->
                        <div class="mb-5">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Descripción:</label>
                            <textarea wire:model="description" id="description"
                                      class="bg-yellow-50 border border-yellow-300 text-gray-500 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Ingrese la descripción" required></textarea>
                            <x-input-error for="description"/>
                        </div>

                        <!-- Campo para el valor -->
                        <div class="mb-5">
                            <label for="unit_price"
                                   class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Valor:</label>
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
                    <button type="button" wire:click="$set('openCreate', false)"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fa-solid fa-ban mr-2"></i> Cancelar
                    </button>
                    <button type="submit"
                            wire:click="createAdditional"
                            wire:loading.attr="disabled"
                            wire:target="createAdditional"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fa-regular fa-floppy-disk mr-2 text-xl"></i> Guardar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

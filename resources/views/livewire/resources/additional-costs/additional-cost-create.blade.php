<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Crear Adicional</span>
    </button>
    <x-dialog-modal maxWidth="2xl" wire:model="openCreate">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-2xl font-semibold text-center text-blue-400 dark:text-white">Crear Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="createAdditionalCost" class="space-y-5 max-w-sm mx-auto">

                    <!-- Campo para el nombre -->
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre:</label>
                        <input wire:model="name" type="text" id="name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese el nombre" required />
                        <x-input-error for="name" />
                    </div>

                    <!-- Campo para la descripción -->
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción:</label>
                        <textarea wire:model="description" id="description"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese la descripción" required></textarea>
                        <x-input-error for="description" />
                    </div>

                    <!-- Campo para el valor -->
                    <div class="mb-5">
                        <label for="unit_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor:</label>
                        <input wire:model="unitPrice" type="number" id="unit_price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese el valor" required />
                        <x-input-error for="unit_price" />
                    </div>

                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="createAdditionalCost"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Crear
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

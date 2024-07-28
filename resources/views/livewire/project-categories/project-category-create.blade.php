<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <div class="flex items-center">
                <i class="fa-solid fa-list-check text-xl mr-2"></i> Nueva Categoría
            </div>
        </span>
    </button>

    <x-dialog-modal maxWidth="3xl" wire:model="openCreate">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
            <x-slot name="title">
                <h2 class="text-2xl font-semibold text-center text-gray-500 dark:text-white py-6">Crear Categoría de Proyecto</h2>
            </x-slot>

            <x-slot name="content">
                <div class="border border-cyan-500 shadow-sm shadow-cyan-500 m-4 p-10 rounded-lg">
                    <form class="space-y-5 mx-auto">
                        <!-- Imagen -->
                        <div class="p-4">
                            <div class="relative">
                                <label
                                    class="flex flex-col items-center justify-center h-48 gap-4 p-6 mx-auto bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-md cursor-pointer w-72">
                                    <div class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ddd"
                                             viewBox="0 0 24 24" class="w-16 h-16 text-gray-600">
                                            <path
                                                d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                                clip-rule="evenodd" fill-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <span class="font-normal text-gray-600">Imagen Categoría de Proyecto</span>
                                    </div>
                                    <input type="file" class="hidden" wire:model="image">
                                    <div class="absolute top-0 h-48 w-72">
                                        @if ($image)
                                            <img class="object-cover w-full h-full rounded-lg mb-4"
                                                 src="{{ $image->temporaryUrl() }}"
                                                 alt="Imagen de Categoría de Proyecto">
                                        @endif
                                    </div>
                                </label>
                                <x-input-error for="image"/>
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Nombre:</label>
                            <input wire:model="name" type="text" id="name"
                                   class="bg-cyan-50 border border-cyan-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-300 focus:border-cyan-300 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Ingrese el nombre" required/>
                            <x-input-error for="name"/>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-5">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Descripción:</label>
                            <textarea wire:model="description" id="description"
                                      class="bg-cyan-50 border border-cyan-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Ingrese la descripción" required></textarea>
                            <x-input-error for="description"/>
                        </div>

                        <!-- Estado -->
                        <div class="mb-5">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Estado:</label>
                            <select wire:model="status" id="status"
                                    class="bg-cyan-50 border border-cyan-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" selected>Seleccione un estado</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            <x-input-error for="status"/>
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
                            wire:click="createCategory"
                            wire:loading.attr="disabled"
                            wire:target="createCategory"
                            class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fa-regular fa-floppy-disk mr-2 text-xl"></i> Guardar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

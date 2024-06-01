<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Nuevo Material</span>
    </button>

    <x-dialog-modal maxWidth="3xl" wire:model="openCreate">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Crear Material</h2>
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="createMaterial" class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">

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
                                    <span class="font-normal text-gray-600">Imagen de Material</span>
                                </div>
                                <input type="file" class="hidden" wire:model="image">
                                <div class="absolute top-0 h-48 w-72">
                                    @if ($image)
                                        <img class="object-cover w-full h-full rounded-lg mb-4"
                                             src="{{ $image->temporaryUrl() }}"
                                             alt="Imagen de Material">
                                    @endif
                                </div>
                            </label>
                            <x-input-error for="image"/>
                        </div>
                    </div>

                    <!-- Dropdown para seleccionar la categoría -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="category" class="block text-gray-700">Categoría:</label>
                        <select wire:model="selectedCategory" id="category"
                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" wire:key="category_">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="selectedCategory"/>
                    </div>

                    <!-- Campo para ingresar la referencia del material -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="reference" class="block text-gray-700">Referencia:</label>
                        <input wire:model="reference" type="text" id="reference"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="reference"/>
                    </div>

                    <!-- Campo para ingresar la descripción del material -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="description" class="block text-gray-700">Descripción:</label>
                        <textarea wire:model="description" id="description"
                                  class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-30 px-4 my-2"></textarea>
                        <x-input-error for="description"/>
                    </div>

                    <!-- Campo para ingresar el precio unitario del material -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="unitPrice" class="block text-gray-700">Precio Unitario:</label>
                        <input wire:model="unitPrice" type="number" id="unitPrice"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="unitPrice"/>
                    </div>

                </form>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="createMaterial"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Crear
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

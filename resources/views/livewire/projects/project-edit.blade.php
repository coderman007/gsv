<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-edit"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal maxWidth="3xl" wire:model="openEdit">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Editar Proyecto</h2>
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="updateProject" class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">
                    <!-- Dropdown para seleccionar la categoría -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="selectedCategory" class="block text-gray-700">Categoría:</label>
                        <select wire:model="selectedCategory" id="selectedCategory"
                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="selectedCategory"/>
                    </div>

                    <!-- Campo para ingresar el nombre del proyecto -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="name" class="block text-gray-700">Nombre:</label>
                        <input wire:model="name" type="text" id="name"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="name"/>
                    </div>

                    <!-- Campo para ingresar la descripción del proyecto -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="description" class="block text-gray-700">Descripción:</label>
                        <textarea wire:model="description" id="description"
                                  class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-30 px-4 my-2"></textarea>
                        <x-input-error for="description"/>
                    </div>

                    <!-- Campo para ingresar los kilovatios a proporcionar -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="kilowattsToProvide" class="block text-gray-700">Kilovatios a Proporcionar:</label>
                        <input wire:model="kilowattsToProvide" type="number" id="kilowattsToProvide"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="kilowattsToProvide"/>
                    </div>

                    <!-- Campo para ingresar el estado del proyecto -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <select wire:model="status"
                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-4"
                                required="required">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                        <x-input-error for="status"/>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="updateProject"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Actualizar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

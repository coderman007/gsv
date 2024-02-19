<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Proyecto</span>
    </button>

    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Proyecto</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <form wire:submit.prevent="createProject">
                    <!-- Nombre del Proyecto -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Proyecto</label>
                        <input type="text" wire:model="name" id="name" name="name"
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input type="text" wire:model="description" id="description" name="description"
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dropdown para Estado -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select wire:model="status" id="status" name="status"
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                            <option value="" disabled>Selecciona un estado</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                        @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Resto de los campos del formulario -->
                    <!-- ... -->

                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <x-secondary-button wire:click="$set('openCreate', false)"
                        class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                        Cancelar
                    </x-secondary-button>
                    <x-secondary-button
                        class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                        wire:click="createProject" wire:loading.attr="disabled" wire:target="createProject">
                        Agregar
                    </x-secondary-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>
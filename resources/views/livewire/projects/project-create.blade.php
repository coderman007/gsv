<div>
    <button wire:click="$set('openCreate', true)" class="absolute right-10 top-10 mt-8 px-4 py-2 rounded-md text-blue-500 bg-blue-100 border border-blue-500 shadow-md hover:shadow-blue-400 hover:bg-blue-400 hover:text-white">
        <i class="fa fa-solid fa-user-plus text-xl"></i> Agregar
    </button>

    <x-dialog-modal wire:model="openCreate">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Nuevo Proyecto</h2>
        </x-slot>

        <div class="w-1">
            <x-slot name="content">
                <form wire:submit="createProject">
                    <!-- Cliente del Proyecto -->
                    <div class="mb-4">
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                        <select wire:model="client_id" id="client_id" name="client_id" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                            <option value="" disabled>Selecciona un cliente</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nombre del Proyecto -->
                    <div class="mb-4">
                        <label for="project_name" class="block text-sm font-medium text-gray-700">Nombre del Proyecto</label>
                        <input type="text" wire:model="project_name" id="project_name" name="project_name" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('project_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tipo de Proyecto -->
                    <div class="mb-4">
                        <label for="project_type" class="block text-sm font-medium text-gray-700">Tipo de Proyecto</label>
                        <input type="text" wire:model="project_type" id="project_type" name="project_type" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('project_type') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input type="text" wire:model="description" id="description" name="description" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kilowatts Requeridos -->
                    <div class="mb-4">
                        <label for="required_kilowatts" class="block text-sm font-medium text-gray-700">Kilowatts Requeridos</label>
                        <input type="number" wire:model="required_kilowatts" id="required_kilowatts" name="required_kilowatts" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('required_kilowatts') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha de inicio -->
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de inicio</label>
                        <input type="date" wire:model="start_date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Término Estimado -->
                    <div class="mb-4">
                        <label for="expected_end_date" class="block text-sm font-medium text-gray-700">Término Estimado</label>
                        <input type="date" wire:model="expected_end_date" id="expected_end_date" name="expected_end_date" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @error('expected_end_date') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dropdown para Estado -->
                    <x-label value="Estado" class="text-gray-700" />
                    <select class="w-full mb-4 rounded-md" wire:model="status">
                        <option value="" disabled>Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                    <x-input-error for="status" />
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="mx-auto">
                    <x-secondary-button wire:click="$set('openCreate', false)" class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                        Cancelar
                    </x-secondary-button>
                    <x-secondary-button class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white" wire:click="createProject" wire:loading.attr="disabled" wire:target="createProject">
                        Agregar
                    </x-secondary-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

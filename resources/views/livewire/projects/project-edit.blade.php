<div>
    <div class="relative inline-block text-center cursor-pointer group">
        <a href="#" wire:click="$set('openEdit', true)">
            <i class="p-1 text-blue-400 rounded hover:text-white hover:bg-blue-500 fa-solid fa-pen-to-square"></i>
            <div class="absolute z-10 px-3 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-6">
                Editar
                <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                </svg>
            </div>
        </a>
    </div>

    <x-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <h2 class="mt-3 text-2xl text-center">Actualizar Proyecto</h2>
        </x-slot>

        <x-slot name="content">
            <form wire:submit="updateProject">

                <!-- Cliente del Proyecto -->
                <div class="mb-4">
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                    <select wire:model="client_id" id="client_id" name="client_id" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
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
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                    <input type="date" wire:model="start_date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Término Estimado -->
                <div class="mb-4">
                    <label for="expected_end_date" class="block text-sm font-medium text-gray-700">Término Estimado</label>
                    <input type="date" wire:model="expected_end_date" id="expected_end_date" name="expected_end_date" class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    @error('expected_end_date') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="mx-auto">
                <x-secondary-button wire:click="$set('openEdit', false)" class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:shadow-gray-400">
                    Cancelar
                </x-secondary-button>
                <x-secondary-button class="text-blue-500 border border-blue-500 shadow-lg hover:shadow-blue-400 disabled:opacity-25" wire:click="updateProject" wire:loading.attr="disabled">
                    Actualizar
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

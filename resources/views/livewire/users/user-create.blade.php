<div>
    {{-- <div class="bg-green-300">
        @if(session('message'))
        {{session('message')}}
    @endif
</div> --}}
<button wire:click="$set('openCreate', true)" class="absolute right-10 top-10 mt-8 px-4 py-2 rounded-md text-blue-500 bg-blue-100 border border-blue-500 shadow-md hover:shadow-blue-400 hover:bg-blue-400 hover:text-white">
    <i class="fa fa-solid fa-user-plus text-xl"></i> Agregar
</button>

<x-dialog-modal wire:model="openCreate">
    <x-slot name="title">
        <h2 class="mt-3 text-2xl text-center">Nuevo Usuario</h2>
    </x-slot>

    <div class="w-1">
        <x-slot name="content">
            <form>
                <!-- Nombre -->
                <x-label value="Nombre" class="text-gray-700" />
                <x-input class="w-full" wire:model.blur="name" />
                <x-input-error for="name" />

                <!-- Correo Electrónico -->
                <x-label value="Correo Electrónico" class="text-gray-700" />
                <x-input class="w-full" wire:model.blur="email" type="email" />
                <x-input-error for="email" />

                <!-- Contraseña -->
                <x-label value="Contraseña" class="text-gray-700" />
                <x-input class="w-full" wire:model.blur="password" type="password" />
                <x-input-error for="password" />

                <!-- Dropdown para Estado -->
                <x-label value="Estado" class="text-gray-700" />
                <select class="w-full mb-4 rounded-md" wire:model.blur="status">
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
                <x-secondary-button class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white" wire:click="createUser" wire:loading.attr="disabled" wire:target="createUser">
                    Agregar
                </x-secondary-button>
            </div>
        </x-slot>
    </div>
</x-dialog-modal>
</div>

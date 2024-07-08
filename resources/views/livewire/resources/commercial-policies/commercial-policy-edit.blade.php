<div>
    <div class="relative inline-block text-center cursor-pointer group">
        <!-- Botón para abrir el diálogo modal -->
        <a href="#" wire:click="$set('openEdit', true)">
            <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <!-- Tooltip para la opción de editar -->
            <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
                Editar
                <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"></svg>
            </div>
        </a>
    </div>

    <!-- Diálogo modal para editar una política comercial -->
    <x-dialog-modal wire:model="openEdit">
        <x-slot name="title">
            <div class="my-4 text-center text-blue-500 text-xl">
                Editar Política Comercial
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- Sección para editar la política comercial -->
            <div class="mt-5 bg-white rounded-lg shadow p-6">
                <!-- Campo para el nombre de la política -->
                <div>
                    <x-label class="text-left text-lg text-gray-700" value="Nombre de la Política" />
                    <input wire:model="name"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" readonly>
                    <x-input-error for="name" />
                </div>

                <!-- Campo para el porcentaje -->
                <div class="mt-4">
                    <x-label class="text-left text-lg text-gray-700" value="Porcentaje (%)" />
                    <input wire:model="percentage" type="number" step="0.01"
                           class="text-gray-800 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <x-input-error for="percentage" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-4 p-4 border-t border-gray-300">
                <!-- Botón para cancelar y cerrar el diálogo -->
                <button wire:click="$toggle('openEdit')"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none transition duration-200">
                    Salir
                </button>

                <!-- Botón para guardar cambios -->
                <button wire:click="updateCommercialPolicy"
                        wire:loading.attr="disabled"
                        wire:target="updateCommercialPolicy"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none transition duration-200">
                    Guardar Cambios
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

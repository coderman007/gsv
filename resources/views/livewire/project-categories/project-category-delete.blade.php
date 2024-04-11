<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openDelete', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-red-300 to-red-500 hover:from-red-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-trash"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Eliminar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px"
                 viewBox="0 0 255 255" xml:space="preserve">
                                            </svg>
        </div>
    </a>
    {{-- Modal de Confirmación de Eliminación de categorías de proyectos --}}
    @if ($openDelete)
    <div wire:model="openDelete">
        <div class="fixed inset-0 z-50 flex items-center justify-center" wire:click="$set('openDelete', false)">
            <div class="absolute inset-0 z-40 bg-black opacity-70 modal-overlay"></div>
            <div
                class="z-50 w-11/12 mx-auto overflow-y-auto bg-white border border-red-500 rounded-xl modal-container md:max-w-md">
                <!-- Contenido del modal -->
                <div class="flex gap-3 py-2 bg-red-500 border border-red-500">
                    <h3 class="w-full text-2xl text-center text-gray-100">Eliminar</h3>
                </div>
                <div class="px-6 py-4 text-left modal-content">
                    <p class="text-xl text-gray-500">
                        ¿Estás seguro de que deseas eliminar esta categoría de proyecto?
                    </p>
                    <div class="mt-4 text-center">
                        <x-secondary-button wire:click="$set('openDelete', false)"
                            class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:text-gray-50 hover:shadow-gray-400 hover:bg-gray-400">
                            Cancelar
                        </x-secondary-button>
                        <x-secondary-button wire:click="deleteCategory"
                            class="mr-4 text-red-500 border border-red-500 shadow-lg hover:text-gray-50 hover:shadow-red-400 hover:bg-red-400">
                            Eliminar
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

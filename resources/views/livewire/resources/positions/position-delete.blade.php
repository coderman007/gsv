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


    {{-- Modal de Confirmación de Eliminación de transporte. --}}
    @if ($openDelete)
        <div wire:model="openDelete">
            <!-- Contenido del modal de confirmación de eliminación -->
            <div class="fixed inset-0 z-50 flex items-center justify-center" wire:click="$set('openDelete', false)">
                <div class="absolute inset-0 z-40 bg-black opacity-70 modal-overlay"></div>
                <div
                    class="z-50 w-full mx-auto overflow-y-auto bg-white border-4 border-red-500 rounded-xl modal-container md:max-w-md">
                    <!-- Contenido del modal -->
                    <div class="relative p-4 w-full max-w-md">
                        <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                wire:click="$set('openDelete', false)">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>

                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-red-500 w-12 h-12 dark:text-red-200" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-2xl font-normal p-4 text-gray-500 dark:text-gray-400">¿Estás seguro de
                                eliminar esta posición de trabajo?</h3>
                            <div class="flex gap-3">
                                <button wire:click="$set('openDelete', false)" type="button"
                                        class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-gray-600 disabled:text-white">
                                    <div class="flex gap-4 items-center">
                                        <i class="fa-solid fa-ban text-xl"></i>
                                        <span class="text-lg">Cancelar</span>
                                    </div>
                                </button>

                                <button wire:click="deletePosition" type="button"
                                        class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-700 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-red-600 disabled:text-white"
                                        wire:loading.attr="disabled" wire:target="deletePosition">
                                    <div class="flex gap-4 items-center">
                                        <i class="fa-solid fa-trash-arrow-up text-xl"></i>
                                        <span class="text-lg">Sí, eliminar</span>
                                    </div>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

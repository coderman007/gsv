<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openDelete', true)">
        <i class="p-1 text-red-400 rounded hover:text-white hover:bg-red-400 fa-solid fa-trash"></i>
        <div
            class="absolute z-10 px-2 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Eliminar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                xml:space="preserve">
            </svg>
        </div>
    </a>

    {{-- Modal de Confirmación de Eliminación de mano de obra. --}}
    @if ($openDelete)
    <div wire:model="openDelete">
        <div class="fixed inset-0 z-50 flex items-center justify-center" wire:click="$set('openDelete', false)">
            <div class="absolute inset-0 z-40 bg-black opacity-70 modal-overlay"></div>
            <div
                class="z-50 w-full mx-auto overflow-y-auto bg-white border-4 border-red-500 rounded-xl modal-container md:max-w-md">

                <!-- Contenido del modal -->
                <div class="relative p-4 w-full max-w-md max-h-[insert_valor_aqui]">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            wire:click="$set('openDelete', false)">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-red-500 w-12 h-12 dark:text-red-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-2xl font-normal p-4 text-gray-500 dark:text-gray-400">Está seguro de
                                hacer esto?</h3>

                            <div class="flex gap-3">
                                <button wire:click="deleteLabor" type="button"
                                    class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-700 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-red-600 disabled:text-white"
                                    wire:click="updateLabor" wire:loading.attr="disabled" wire:target="updateLabor">
                                    <span class="mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 512 512"
                                            width="24px" fill="#FFFFFF">
                                            <path
                                                d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM135.1 217.4c-4.5 4.2-7.1 10.1-7.1 16.3c0 12.3 10 22.3 22.3 22.3H208v96c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V256h57.7c12.3 0 22.3-10 22.3-22.3c0-6.2-2.6-12.1-7.1-16.3L269.8 117.5c-3.8-3.5-8.7-5.5-13.8-5.5s-10.1 2-13.8 5.5L135.1 217.4z" />
                                        </svg>
                                    </span>
                                    Estoy Seguro
                                </button>
                                <button wire:click="$set('openDelete', false)" type="button"
                                    class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-gray-600 disabled:text-white"
                                    wire:click="updateLabor" wire:loading.attr="disabled" wire:target="updateLabor">
                                    <span class="pl-2 mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" fill="#FFFFFF"
                                            height="24px" viewBox="0 0 512 512">
                                            <path
                                                d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z" />
                                        </svg>
                                    </span>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
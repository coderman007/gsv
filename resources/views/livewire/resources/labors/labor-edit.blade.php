<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <i class="p-1 text-blue-400 rounded hover:text-white hover:bg-blue-500 fa-solid fa-pen-to-square"></i>
        <div
            class="absolute z-10 px-3 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-6">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openEdit">
        <div class="flex h-screen bg-gray-200">
            <div class="m-auto">
                <div class="w-1">
                    <x-slot name="title"></x-slot>
                    <x-slot name="content">
                        <div>
                            <div
                                class="relative w-full flex justify-center items-center p-5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none transition duration-500 transform active:scale-95 ease-in-out">
                                <span class="pl-2 mx-1">
                                    <h2 class="mt-3 text-2xl text-center">Actualizar Mano de Obra</h2>
                                </span>
                            </div>
                            <div class="mt-5 bg-white rounded-lg shadow">

                                <!-- Posición -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Posición" />
                                    <input wire:model="position"
                                        class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="position" />
                                </div>

                                <!-- Básico -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Básico" />
                                    <x-input type="number" wire:model="basic"
                                        class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" />
                                    <x-input-error for="basic" />
                                </div>

                                <!-- Factor de Beneficio -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Factor de Beneficio" />
                                    <x-input type="number" wire:model="benefit_factor"
                                        class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" />
                                    <x-input-error for="benefit_factor" />
                                </div>

                                <!-- Costo Mensual Real -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Costo Mensual Real" />
                                    <x-input type="number" wire:model="real_monthly_cost"
                                        class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" />
                                    <x-input-error for="real_monthly_cost" />
                                </div>

                                <!-- Costo Diario Real -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Costo Diario Real" />
                                    <x-input type="number" wire:model="real_daily_cost"
                                        class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" />
                                    <x-input-error for="real_daily_cost" />
                                </div>

                            </div>
                        </div>
                    </x-slot>

                    <hr class="mt-4">

                    <x-slot name="footer">
                        <div class="mx-auto">
                            <div class="flex gap-16">
                                <button type="button" wire:click="$toggle('openEdit')"
                                    class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition duration-300 transform active:scale-95 ease-in-out">
                                    <span class="pl-2 mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" fill="#FFFFFF"
                                            height="24px" viewBox="0 0 512 512">
                                            <path
                                                d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z" />
                                        </svg>
                                    </span>
                                    Salir
                                </button>

                                <button type="button"
                                    class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-blue-500 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                                    wire:click="updateLabor" wire:loading.attr="disabled" wire:target="updateLabor">
                                    <span class="mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 512 512"
                                            width="24px" fill="#FFFFFF">
                                            <path
                                                d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM135.1 217.4c-4.5 4.2-7.1 10.1-7.1 16.3c0 12.3 10 22.3 22.3 22.3H208v96c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V256h57.7c12.3 0 22.3-10 22.3-22.3c0-6.2-2.6-12.1-7.1-16.3L269.8 117.5c-3.8-3.5-8.7-5.5-13.8-5.5s-10.1 2-13.8 5.5L135.1 217.4z" />
                                        </svg>
                                    </span>
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </x-slot>
                </div>
            </div>
        </div>
    </x-dialog-modal>
</div>
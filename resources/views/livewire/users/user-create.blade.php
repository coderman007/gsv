<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-user-plus text-xl"></i> Nuevo Usuario</span>
    </button>

    <x-dialog-modal wire:model="openCreate">
        <div class="flex h-screen bg-gray-200">
            <div class="m-auto">
                <div class="w-1">
                    <x-slot name="title">
                    </x-slot>
                    <x-slot name="content">
                        <div>
                            <div
                                class="relative w-full flex justify-center items-center p-5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none transition duration-500 transform active:scale-95 ease-in-out">
                                <span class="pl-2 mx-1">
                                    <h2 class="mt-3 text-2xl text-center">Crear Usuario</h2>
                                </span>
                            </div>
                            <div class="mt-5 bg-white rounded-lg shadow">
                                <!-- Nombre -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Nombre" />
                                    <input wire:model="name" placeholder="Nombre"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="name" />
                                </div>
                                <!-- Dropdown para Rol -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Tipo de Usuario" />
                                    <select wire:model="selectedRole"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                        <option value="" disabled>Selecciona un Tipo</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="selectedRole" />
                                </div>
                                <!-- Correo Electrónico -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Correo Electrónico" />
                                    <input wire:model="email" type="email" placeholder="Correo Electrónico"
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                    <x-input-error for="email" />
                                </div>
                                <!-- Contraseña -->
                                <div class="px-5 pb-5">
                                    <x-label class="text-left text-xl text-gray-700" value="Contraseña" />
                                    <x-input
                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"
                                        wire:model="password" type="password" placeholder="Contraseña" />
                                    <x-input-error for="password" />
                                </div>
                            </div>
                        </div>
                    </x-slot>
                    <hr class="mt-4">
                    <x-slot name="footer">
                        <div class="mx-auto">
                            <div class="flex gap-16">
                                <button type="button" wire:click="$toggle('openCreate')"
                                    class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition duration-300 transform active:scale-95 ease-in-out">
                                    <span class="mx-1">
                                        <svg class="w-5 h-5 mr-2 font-extrabold " fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12">
                                            </path>
                                        </svg>
                                    </span>
                                    Salir
                                </button>
                                <button type="button"
                                    class="relative w-full flex justify-center items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize bg-gray-500 rounded-md hover:bg-blue-500 focus:outline-none transition duration-300 transform active:scale-95 ease-in-out disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                                    wire:click="createUser" wire:loading.attr="disabled" wire:target="createUser">
                                    <span class="mx-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 640 512"
                                            width="24px" fill="#FFFFFF">
                                            <path
                                                d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                        </svg>
                                    </span>
                                    Crear
                                </button>
                            </div>
                        </div>
                    </x-slot>
                </div>
            </div>
        </div>
    </x-dialog-modal>
</div>

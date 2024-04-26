<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>
    <x-dialog-modal maxWidth="2xl" wire:model="openEdit">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">

            <x-slot name="title">
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-blue-400 dark:text-white">Actualizar Cliente</h2>
                </div>
            </x-slot>

            <x-slot name="content">
                <form wire:submit="updateClient" enctype="multipart/form-data">
                    <div class="my-5">
                        <div class="flex justify-between my-6">
                            <!-- Tipo de Cliente -->
                            <div class="w-1/2 pr-2 flex justify-center items-center">
                                <div class="text-center">
                                    <label class="text-lg font-semibold text-gray-600 py-2">
                                        Tipo de Cliente
                                        @if (!$type)
                                            <span class="text-red-500">*</span> <!-- Asterisco rojo -->
                                        @elseif ($type === 'Persona' || $type === 'Empresa')
                                            <span class="text-green-500">&#10003;</span> <!-- Chulito verde -->
                                        @endif
                                    </label>
                                    <div class="flex items-center space-x-4 justify-center">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model.live="type" value="Persona"
                                                class="form-radio text-blue-500"
                                                @if ($type === 'Persona') checked @endif>
                                            <span class="ml-2 text-gray-700">Persona</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model.live="type" value="Empresa"
                                                class="form-radio text-blue-500"
                                                @if ($type === 'Empresa') checked @endif>
                                            <span class="ml-2 text-gray-700">Empresa</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="w-1/2 pl-2">
                                @if ($type)
                                    <div class="relative">
                                        <label
                                            class="flex flex-col items-center justify-center h-48 gap-4 p-6 mx-auto bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-md cursor-pointer w-72">
                                            <div class="flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#ddd"
                                                    viewBox="0 0 24 24" class="w-16 h-16 text-gray-600">
                                                    <path
                                                        d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                                        clip-rule="evenodd" fill-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <span class="font-normal text-gray-600">Imagen Cliente</span>
                                            </div>
                                            <input type="file" class="hidden" wire:model="image">
                                            <div class="absolute top-0 h-48 w-72">
                                                @if ($image)
                                                    <img class="object-cover w-full h-full rounded-lg mb-4" src="{{ $image->temporaryUrl() }}" alt="Imagen del cliente">
                                                @else
                                                    <img class="object-cover w-full h-full rounded-lg mb-4" src="{{ asset('storage/' . $client->image) }}" alt="Imagen del cliente">
                                                @endif
                                            </div>
                                        </label>
                                        <x-input-error for="image" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Campo de búsqueda de ciudad con sugerencias -->
                        <label for="city" class="text-lg font-semibold text-gray-600 py-2">
                            Ciudad
                        </label>
                        <input type="text" id="city" wire:model.live="city" placeholder="Buscar ciudad"
                            class="form-input rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 w-full">
                        @if ($filteredCities && count($filteredCities) > 0)
                            <ul class="mt-2 border border-gray-300 rounded-md shadow-sm absolute z-10 bg-white w-full">
                                @foreach ($filteredCities as $filteredCity)
                                    <li class="py-1 px-3 cursor-pointer hover:bg-gray-100"
                                        wire:click="selectCity('{{ $filteredCity }}')">
                                        {{ $filteredCity }}
                                    </li>
                                @endforeach
                            </ul>

                            <x-input-error for="city" />
                        @endif

                        <!-- Campos específicos para Personas -->
                        @if ($type === 'Persona')
                            <x-person-client-form />
                        @endif

                        <!-- Campos específicos para Empresas -->
                        @if ($type === 'Empresa')
                            <x-company-client-form />
                        @endif
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <div class="mt-5 flex justify-end">
                    <button type="submit" wire:click="updateClient"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Actualizar Cliente
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

<div>
    <x-info-button wire:click="$set('openCreate', true)">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Cliente
    </x-info-button>

    <x-dialog-modal maxWidth="5xl" wire:model="openCreate">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">

            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-gray-600">Información del Cliente</h2>
            </x-slot>
            <x-slot name="content">

                <form wire:submit="createClient">
                    <div class="my-2">
                        <div class="flex justify-between my-4">
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
                                    <x-input-error for="type" />
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
                                                    <img class="object-cover w-full h-full mb-4 rounded-lg"
                                                        src="{{ $image->temporaryUrl() }}"
                                                        alt="Foto de Perfil">
                                                @endif
                                            </div>
                                        </label>
                                        <x-input-error for="image" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($type)
                            <!-- Campo de búsqueda de ciudad con sugerencias -->
                            <label for="city" class="text-lg font-semibold text-gray-600 py-2">
                                Ciudad
                            </label>
                            <input type="text" id="city" wire:model.live="city" placeholder="Buscar ciudad"
                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                            @if ($filteredCities && count($filteredCities) > 0)
                                <ul
                                    class="mt-2 border border-gray-300 rounded-md shadow-sm absolute z-10 bg-white w-full">
                                    @foreach ($filteredCities as $filteredCity)
                                        <li class="py-1 px-3 cursor-pointer hover:bg-gray-100"
                                            wire:click="selectCity('{{ $filteredCity }}')">
                                            {{ $filteredCity }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <x-input-error for="city_id" />
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
                <div class="flex justify-end">
                    <x-info-button wire:click="createClient"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Crear Cliente
                    </x-info-button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>

    @push('js')
        <script>

            Livewire.on('clientStoredNotification', function() {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Cliente Almacenado con éxito!',
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        title: 'swal2-title-small',
                    }
                });
            });
        </script>
    @endpush
</div>

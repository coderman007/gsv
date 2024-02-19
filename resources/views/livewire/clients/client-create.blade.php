<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Cliente</span>
    </button>

    <x-dialog-modal maxWidth="5xl" wire:model="openCreate">
        <div class="max-w-md mx-auto bg-white shadow-md p-6 rounded-md">

            <x-slot name="title">
                <h2 class="font-semibold text-xl text-center pt-4 text-gray-600">Nuevo Cliente</h2>
            </x-slot>
            <x-slot name="content">
                <form>
                    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
                        <div class="container max-w-screen-lg mx-auto">
                            <div>


                                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                        <div class="text-gray-600">
                                            <p class="font-medium text-lg">Información Básica</p>
                                        </div>

                                        <div class="lg:col-span-2">
                                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                                <div class="md:col-span-5">
                                                    <label for="name">Nombre Completo</label>
                                                    <input type="text" name="name" wire="name"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                                        value="" />
                                                    @error('name') <span class="text-red-500">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="md:col-span-5">
                                                    <label for="email">Correo Electrónico</label>
                                                    <input type="text" name="email" wire:model="email"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=""
                                                        placeholder="email@domain.com" />
                                                    @error('email') <span class="text-red-500">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                                <!-- Teléfono -->
                                                <div class="md:col-span-5">
                                                    <label for="phone"
                                                        class="block text-sm font-medium text-gray-700">Teléfono</label>
                                                    <input type="text" wire:model="phone" id="phone" name="phone"
                                                        class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                                    @error('phone') <span class="text-red-500">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Transformador -->
                                                <div class="md:col-span-5">
                                                    <label for="transformer"
                                                        class="block text-sm font-medium text-gray-700">Transformador</label>
                                                    <select wire:model="transformer"
                                                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                                                        <option value="" disabled selected>Seleccione un Tipo de
                                                            Transformador</option>
                                                        <option value="Trifásico">Trifásico</option>
                                                        <option value="Monofásico">Monofásico</option>
                                                    </select>
                                                    <x-input-error for="transformer" />
                                                </div>

                                                <!-- Consumo de Energía Promedio -->
                                                <div class="md:col-span-5">
                                                    <label for="average_energy_consumption"
                                                        class="block text-sm font-medium text-gray-700">Consumo
                                                        de Energía Promedio</label>
                                                    <input type="number" wire:model="average_energy_consumption"
                                                        id="average_energy_consumption"
                                                        name="average_energy_consumption"
                                                        class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                                    @error('average_energy_consumption') <span class="text-red-500">{{
                                                        $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Nivel de Radiación Solar -->
                                                <div class="md:col-span-5">
                                                    <label for="solar_radiation_level"
                                                        class="block text-sm font-medium text-gray-700">Nivel de
                                                        Radiación Solar</label>
                                                    <input type="number" wire:model="solar_radiation_level"
                                                        id="solar_radiation_level" name="solar_radiation_level"
                                                        class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                                    @error('solar_radiation_level') <span class="text-red-500">{{
                                                        $message }}</span> @enderror
                                                </div>

                                                <!-- Dimensión Cubierta -->
                                                <div class="md:col-span-5">
                                                    <label for="roof_dimension"
                                                        class="block text-sm font-medium text-gray-700">Longitud
                                                        Cubierta</label>
                                                    <input type="number" wire:model="roof_dimension" id="roof_dimension"
                                                        name="roof_dimension"
                                                        class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                                    @error('roof_dimension') <span class="text-red-500">{{
                                                        $message }}</span> @enderror
                                                </div>

                                                <div class="md:col-span-5">
                                                    <livewire:locations.location-dropdown />
                                                </div>

                                                <div class="md:col-span-5 text-right">
                                                    <div class="mx-auto">
                                                        <x-secondary-button wire:click="$set('openCreate', false)"
                                                            class="mr-4 text-gray-500 border border-gray-500 shadow-lg hover:bg-gray-400 hover:shadow-gray-400">
                                                            Cancelar
                                                        </x-secondary-button>
                                                        <x-secondary-button
                                                            class="text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-400 hover:shadow-blue-400 disabled:opacity-50 disabled:bg-blue-600 disabled:text-white"
                                                            wire:click="createClient" wire:loading.attr="disabled"
                                                            wire:target="createClient">
                                                            Agregar
                                                        </x-secondary-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
            </x-slot>
        </div>
    </x-dialog-modal>
</div>
<div>
    <button wire:click="$set('openCreate', true)"
        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Agregar</span>
    </button>

    <x-dialog-modal maxWidth="5xl" wire:model="openCreate">

        <div class="container mx-auto p-4">
            <!-- Formulario de cotización -->
            <form class="bg-white p-8 rounded shadow-md">
                <x-slot name="title">
                    <div class="pr-10">
                        <h2 class="mt-3 text-2xl text-right">Cotización N° </h2>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <!-- Encabezado con botones -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex space-x-4">
                            <div>
                                <livewire:clients.client-create />
                            </div>
                            <div>
                                <livewire:projects.project-create />
                            </div>

                        </div>
                    </div>


                    <!-- Datos del cliente y el proyecto -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Cliente:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Proyecto:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Datos de materiales y herramientas-->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Cliente:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Proyecto:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Datos de mano de obra y transporte -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Total Mano de Obra:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Total Transporte:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Datos de costos adicionales y descripción -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Cliente:</label>
                            <input wire:model="additional_costs" type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">Proyecto:</label>
                            <input type="text"
                                class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    {{-- <div class="flex items-center justify-between mb-4">
                        <button class="px-4 py-2 bg-gray-800 text-white rounded"
                            wire:click="guardarCotizacion">Guardar</button>
                    </div> --}}
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue">Enviar
                            Cotización</button>
                    </div>
                </x-slot>
            </form>
        </div>
    </x-dialog-modal>
</div>
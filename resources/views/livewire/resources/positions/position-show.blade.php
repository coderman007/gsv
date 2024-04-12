<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>
        <!-- Modal de detalle -->
        <x-dialog-modal maxWidth="3xl" wire:model="openShow">
            <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
                <!-- Título del modal -->
                <x-slot name="title">
                    <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Detalle de Posición Laboral</h2>
                </x-slot>

                <!-- Contenido del modal -->
                <x-slot name="content">
                    <div class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">
                        <!-- Nombre -->
                        <div class="space-y-2 w-full text-lg">
                            <label for="name" class="font-semibold text-gray-700">Nombre de la Posición:</label>
                            <p id="name" class="text-gray-800">{{ $position->name }}</p>
                        </div>

                        <!-- Salario Básico -->
                        <div class="space-y-2 w-full text-lg">
                            <label for="basic" class="font-semibold text-gray-700">Salario Básico:</label>
                            <p id="basic" class="text-gray-800">{{ $position->basic }}</p>
                        </div>

                        <!-- Factor de Beneficio -->
                        <div class="space-y-2 w-full text-lg">
                            <label for="benefit_factor" class="font-semibold text-gray-700">Factor de Beneficio:</label>
                            <p id="benefit_factor" class="text-gray-800">{{ $position->benefit_factor }}</p>
                        </div>

                        <!-- Costo Mensual Real -->
                        <div class="space-y-2 w-full text-lg">
                            <label for="real_monthly_cost" class="font-semibold text-gray-700">Costo Mensual Real:</label>
                            <p id="real_monthly_cost" class="text-gray-800">{{ $position->real_monthly_cost }}</p>
                        </div>

                        <!-- Costo Diario Real -->
                        <div class="space-y-2 w-full text-lg">
                            <label for="real_daily_cost" class="font-semibold text-gray-700">Costo Diario Real:</label>
                            <p id="real_daily_cost" class="text-gray-800">{{ $position->real_daily_cost }}</p>
                        </div>
                    </div>
                </x-slot>

                <!-- Pie del modal con el botón de cierre -->
                <x-slot name="footer">
                    <div class="flex justify-end">
                        <button wire:click="$set('openShow', false)"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                            Cerrar Detalle
                        </button>
                    </div>
                </x-slot>
            </div>
        </x-dialog-modal>
</div>

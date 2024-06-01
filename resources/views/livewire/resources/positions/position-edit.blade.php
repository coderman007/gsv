<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openEdit', true)">
        <div
            class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-blue-300 to-blue-500 hover:from-blue-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-edit"></i>
        </div>
        <div
            class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Editar
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255"
                 xml:space="preserve">
            </svg>
        </div>
    </a>

    <!-- Modal de edición -->
    <x-dialog-modal maxWidth="3xl" wire:model.live="openEdit">
        <div class="w-full mx-auto bg-white dark:bg-gray-800 shadow-md p-6 rounded-md">
            <!-- Título del modal -->
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500 dark:text-blue-400">Editar Posición Laboral</h2>
            </x-slot>

            <!-- Contenido del modal -->
            <x-slot name="content">
                <div>
                    <div class="col-span-5 bg-white p-4 rounded-lg">
                        <h2 class="text-center text-lg font-bold mb-4 text-blue-500">Datos</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input id="name" placeholder="Nombre de la posición" wire:model.live="name"
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                <x-input-error for="name" class="mt-2"/>
                            </div>
                            <div class="col-span-1">
                                <label for="basic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Básico</label>
                                <input id="basic" placeholder="Salario Básico" wire:model.live="basic"
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200"
                                       type="number" step="0.01">
                                <x-input-error for="basic" class="mt-2"/>
                            </div>
                            <div class="col-span-1">
                                <label for="benefitFactor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Factor Prestacional</label>
                                <input id="benefitFactor" placeholder="Factor Prestacional" wire:model.live="benefitFactor"
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200"
                                       type="number" step="0.01">
                                <x-input-error for="benefitFactor" class="mt-2"/>
                            </div>
                            <div class="col-span-2 mb-4">
                                <label for="monthlyWorkHours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Horas Mensuales de Trabajo</label>
                                <input id="monthlyWorkHours" placeholder="Horas Mensuales de Trabajo" wire:model.live="monthlyWorkHours"
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200"
                                       type="number" step="0.01">
                                <x-input-error for="monthlyWorkHours" class="mt-2"/>
                            </div>
                            <div class="col-span-1">
                                <label for="realMonthlyCost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Real Mensual</label>
                                <input id="realMonthlyCost" placeholder="Costo Real Mensual" value="{{ number_format($realMonthlyCost, 2) }}" readonly
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200"
                                       type="text">
                                <x-input-error for="realMonthlyCost" class="mt-2"/>
                            </div>
                            <div class="col-span-1">
                                <label for="realDailyCost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Real Diario</label>
                                <input id="realDailyCost" placeholder="Costo Real Diario" value="{{ number_format($realDailyCost, 2) }}" readonly
                                       class="mt-1 p-2 block w-full border-gray-300 dark:border-gray-700 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200"
                                       type="text">
                                <x-input-error for="realDailyCost" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>

            <!-- Botones -->
            <x-slot name="footer">
                <div class="flex justify-end mt-4">
                    <button type="button" wire:click="$set('openEdit', false)" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" wire:click="updatePosition" class="ml-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                        <i class="fas fa-edit mr-2"></i> Actualizar Posición
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

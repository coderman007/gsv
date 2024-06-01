<div>
    <!-- Botón para abrir el modal de creación -->
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-4 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-gray-700 dark:text-gray-200 transition-all duration-300">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative transition duration-700 group-hover:text-white ease">
            <i class="fas fa-plus mr-2"></i> Nueva Posición Laboral
        </span>
    </button>

    <!-- Modal de creación -->
    <x-dialog-modal maxWidth="3xl" wire:model.live="openCreate">
        <div class="w-full mx-auto bg-white dark:bg-gray-800 shadow-md p-6 rounded-md">
            <!-- Título del modal -->
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500 dark:text-blue-400">Crear Nueva
                    Posición Laboral</h2>
            </x-slot>

            <!-- Contenido del modal -->
            <x-slot name="content">
                <form wire:submit.prevent="createPosition" class="space-y-6">
                    <!-- Step 1: Nombre -->
                    <div x-data="{ step: 1 }" class="space-y-6">
                        <div x-show="step === 1" class="space-y-4 relative">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre
                                de la posición</label>
                            <div class="relative">
                                <input id="name" placeholder="Nombre de la posición" wire:model.live="name"
                                       class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required type="text">
                                <button type="button" x-on:click="step = 2"
                                        class="absolute right-0 top-0 mt-16 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-right mr-2"></i>Siguiente
                                </button>
                            </div>
                            @error('name') <span class="text-red-500 mt-2"> {{$message }} </span> @enderror
                        </div>

                        <!-- Step 2: Salario Básico -->
                        <div x-show="step === 2" class="space-y-4">
                            <label for="basic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario
                                Básico</label>
                            <input id="basic" placeholder="Salario Básico" wire:model.live="basic"
                                   class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required type="number" step="0.01">
                            @error('name') <span class="text-red-500 mt-2"> {{$message }} </span> @enderror

                            <div class="flex justify-between mt-4">
                                <button type="button" x-on:click="step = 1"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="button" x-on:click="step = 3"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-right mr-2"></i>Siguiente
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Horas Trabajadas al Mes -->
                        <div x-show="step === 3" class="space-y-4">
                            <label for="monthlyWorkHours"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">Horas Trabajadas
                                al Mes</label>
                            <input id="monthlyWorkHours" placeholder="Horas Trabajadas al Mes"
                                   wire:model.live="monthlyWorkHours"
                                   class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required type="number" step="0.01">
                            <x-input-error for="monthlyWorkHours" class="mt-2"/>
                            <div class="flex justify-between mt-4">
                                <button type="button" x-on:click="step = 2"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="button" x-on:click="step = 4"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-right mr-2"></i>Siguiente
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Factor Prestacional -->
                        <div x-show="step === 4" class="space-y-4">
                            <label for="benefitFactor"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">Factor Prestacional</label>
                            <input id="benefitFactor" placeholder="Factor Prestacional" wire:model.live="benefitFactor"
                                   class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required type="number" step="0.01">
                            <x-input-error for="benefitFactor" class="mt-2"/>
                            <div class="flex justify-between mt-4">
                                <button type="button" x-on:click="step = 3"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="button" x-on:click="step = 5"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-right mr-2"></i>Siguiente
                                </button>
                            </div>
                        </div>

                        <!-- Step 5: Costos -->
                        <div x-show="step === 5" class="space-y-4">
                            <div class="space-y-2">
                                <label for="realMonthlyCost"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Mensual
                                    Real</label>
                                <input id="realMonthlyCost" placeholder="Costo Mensual Real"
                                       value="{{ number_format($realMonthlyCost, 2) }}" readonly
                                       class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required type="text">
                                <x-input-error for="realMonthlyCost" class="mt-2"/>
                            </div>

                            <div class="space-y-2">
                                <label for="realDailyCost"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Diario
                                    Real</label>
                                <input id="realDailyCost" placeholder="Costo Diario Real"
                                       value="{{ number_format($realDailyCost, 2) }}" readonly
                                       class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required type="text">
                                <x-input-error for="realDailyCost" class="mt-2"/>
                            </div>

                            <div class="flex justify-between mt-4">
                                <button type="button" x-on:click="step = 4"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="submit" wire:click="createPosition"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                                    <i class="fas fa-plus mr-2"></i> Crear Posición
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    {{--                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300" wire:click="close">Cerrar</button>--}}
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>


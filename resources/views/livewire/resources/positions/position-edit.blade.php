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
        <x-dialog-modal maxWidth="3xl" wire:model="openEdit">
            <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
                <!-- Título del modal -->
                <x-slot name="title">
                    <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Editar Posición Laboral</h2>
                </x-slot>

                <!-- Contenido del modal -->
                <x-slot name="content">
                    <form wire:submit.prevent="updatePosition" class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">
                        <!-- Nombre -->
                        <div class="space-y-2 w-full text-md">
                            <label for="name" class="font-semibold">Nombre de la posición:</label>
                            <input id="name" placeholder="Nombre de la posición" wire:model.defer="name"
                                   class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                                   required="required" type="text">
                            <x-input-error for="name"/>
                        </div>

                        <!-- Salario Básico -->
                        <div class="space-y-2 w-full text-md">
                            <label for="basic" class="font-semibold">Salario Básico:</label>
                            <input id="basic" placeholder="Salario Básico" wire:model.defer="basic"
                                   class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                                   required="required" type="number" step="0.01">
                            <x-input-error for="basic"/>
                        </div>

                        <!-- Factor de Beneficio -->
                        <div class="space-y-2 w-full text-md">
                            <label for="benefit_factor" class="font-semibold">Factor de Beneficio:</label>
                            <input id="benefit_factor" placeholder="Factor de Beneficio" wire:model.defer="benefit_factor"
                                   class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                                   required="required" type="number" step="0.01">
                            <x-input-error for="benefit_factor"/>
                        </div>

                        <!-- Costo Mensual Real -->
                        <div class="space-y-2 w-full text-md">
                            <label for="real_monthly_cost" class="font-semibold">Costo Mensual Real:</label>
                            <input id="real_monthly_cost" placeholder="Costo Mensual Real" wire:model.defer="real_monthly_cost"
                                   class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                                   required="required" type="number" step="0.01">
                            <x-input-error for="real_monthly_cost"/>
                        </div>

                        <!-- Costo Diario Real -->
                        <div class="space-y-2 w-full text-md">
                            <label for="real_daily_cost" class="font-semibold">Costo Diario Real:</label>
                            <input id="real_daily_cost" placeholder="Costo Diario Real" wire:model.defer="real_daily_cost"
                                   class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                                   required="required" type="number" step="0.01">
                            <x-input-error for="real_daily_cost"/>
                        </div>
                    </form>
                </x-slot>

                <!-- Pie del modal con el botón de actualización -->
                <x-slot name="footer">
                    <div class="flex justify-end">
                        <button type="submit" wire:click="updatePosition"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                            Actualizar Posición
                        </button>
                    </div>
                </x-slot>
            </div>
        </x-dialog-modal>
    </div>

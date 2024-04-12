<div>
    <!-- Botón para abrir el modal de creación -->
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
            <i class="fa fa-solid fa-plus text-xl"></i> Nueva Posición Laboral
        </span>
    </button>

    <!-- Modal de creación -->
    <x-dialog-modal maxWidth="3xl" wire:model="openCreate">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
            <!-- Título del modal -->
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Crear Nueva Posición Laboral</h2>
            </x-slot>

            <!-- Contenido del modal -->
            <x-slot name="content">
                <form wire:submit.prevent="createPosition" class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">
                    <!-- Nombre -->
                    <div class="space-y-2 w-full text-xs">
                        <input placeholder="Nombre de la posición" wire:model="name"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                               required="required" type="text">
                        <x-input-error for="name"/>
                    </div>

                    <!-- Salario Básico -->
                    <div class="space-y-2 w-full text-xs">
                        <input placeholder="Salario Básico" wire:model="basic"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                               required="required" type="number" step="0.01">
                        <x-input-error for="basic"/>
                    </div>

                    <!-- Factor de Beneficio -->
                    <div class="space-y-2 w-full text-xs">
                        <input placeholder="Factor de Beneficio" wire:model="benefitFactor"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                               required="required" type="number" step="0.01">
                        <x-input-error for="benefitFactor"/>
                    </div>

                    <!-- Costo Mensual Real -->
                    <div class="space-y-2 w-full text-xs">
                        <input placeholder="Costo Mensual Real" wire:model="realMonthlyCost"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                               required="required" type="number" step="0.01">
                        <x-input-error for="realMonthlyCost"/>
                    </div>

                    <!-- Costo Diario Real -->
                    <div class="space-y-2 w-full text-xs">
                        <input placeholder="Costo Diario Real" wire:model="realDailyCost"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                               required="required" type="number" step="0.01">
                        <x-input-error for="realDailyCost"/>
                    </div>
                </form>
            </x-slot>

            <!-- Pie del modal con el botón de creación -->
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="createPosition"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Crear Posición
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

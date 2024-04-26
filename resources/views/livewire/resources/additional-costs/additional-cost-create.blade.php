<div>
    <button wire:click="$set('openCreate', true)"
            class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
        <span
            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                class="fa fa-solid fa-plus text-xl"></i> Crear Adicional</span>
    </button>

    <x-dialog-modal maxWidth="3xl" wire:model="openCreate">
        <div class="w-full mx-auto bg-white shadow-md p-6 rounded-md">
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-blue-500">Crear Adicional</h2>
            </x-slot>

            <x-slot name="content">
                <form wire:submit="createAdditionalCost" class="flex flex-col items-center mt-6 p-4 bg-gray-50 rounded-lg">

                    <!-- Campo para ingresar el nombre del adicional -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="name" class="block text-gray-700">Concepto:</label>
                        <input wire:model="name" type="text" id="name"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="name"/>
                    </div>

                    <!-- Campo para ingresar la descripción del adicional -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="description" class="block text-gray-700">Descripción:</label>
                        <textarea wire:model="description" id="description"
                                  class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-30 px-4 my-2"></textarea>
                        <x-input-error for="description"/>
                    </div>

                    <!-- Campo para ingresar el valor del adicional -->
                    <div class="space-y-2 w-3/4 text-xs">
                        <label for="amount" class="block text-gray-700">Valor:</label>
                        <input wire:model="amount" type="number" id="amount"
                               class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2">
                        <x-input-error for="amount"/>
                    </div>

                </form>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button type="submit" wire:click="createAdditionalCost"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-md">
                        Crear
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

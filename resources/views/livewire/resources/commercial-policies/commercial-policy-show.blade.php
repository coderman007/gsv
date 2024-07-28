<div class="relative inline-block text-center cursor-pointer group">
    <!-- Botón para abrir el diálogo modal -->
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <!-- Tooltip que aparece al pasar el ratón -->
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"></svg>
        </div>
    </a>

    <!-- Diálogo modal para mostrar detalles de la política comercial -->
    <x-dialog-modal maxWidth="3xl" wire:model="openShow">
        <div class="w-full mx-auto bg-white dark:bg-gray-800 shadow-md p-6 rounded-md">
            <!-- Título del modal -->
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-gray-500 dark:text-gray-300">Detalle de Política Comercial</h2>
            </x-slot>
            <!-- Contenido del modal -->
            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <!-- Nombre -->
                    <div class="space-y-2 md:col-span-2">
                        <p id="name"
                           class="text-violet-500 dark:text-violet-200 text-2xl font-bold p-4 dark:bg-violet-600 rounded-lg">{{ ucfirst($commercialPolicy->name) }}</p>
                    </div>

                    <!-- Porcentaje -->
                    <div class="space-y-2">
                        <label for="percentage" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Porcentaje:</label>
                        <div class="px-6 py-4 dark:text-lg">
                            <div class="bg-violet-100 p-2 rounded-sm font-semibold text-center text-lg">
                                <span>{{ $commercialPolicy->percentage }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción (si existe) -->
                    @if($commercialPolicy->description)
                        <div class="space-y-2">
                            <label for="description" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Descripción:</label>
                            <div class="px-6 py-4 dark:text-lg">
                                <div class="bg-violet-100 p-2 rounded-sm font-semibold text-center text-lg">
                                    <span>{{ $commercialPolicy->description }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-slot>

            <!-- Pie del modal con el botón de cierre -->
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button wire:click="$set('openShow', false)"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Cerrar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

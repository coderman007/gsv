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

    <x-dialog-modal wire:model="openShow" maxWidth="4xl">
        <x-slot name="title">
            <h2 class="text-2xl font-semibold text-center text-gray-500 dark:text-white py-6">Detalle de la
                Categoría</h2>
        </x-slot>

        <x-slot name="content">
            <div class="w-full h-auto bg-white dark:bg-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                    @if($category->image)
                        <div class="col-span-1 md:col-span-2 mb-4 flex justify-center">
                            <div class="w-72 rounded-lg overflow-hidden border-2 border-blue-500">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                     class="w-full h-auto rounded-lg">
                            </div>
                        </div>
                    @endif
                    <div class="space-y-2">
                        <label for="capacity"
                               class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Capacidad:</label>
                        <div class="px-6 py-4 dark:text-lg">
                            <div class="bg-cyan-100 p-2 rounded-sm font-semibold text-center text-lg">
                                <span>{{ $category->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="capacity"
                               class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Estado:</label>
                        <div class="px-6 py-4 dark:text-lg">
                            <div class="bg-cyan-100 rounded-sm font-semibold text-center text-lg">
                                <p class="text-lg py-2 rounded-md {{ $category->status == 'Activo' ? 'text-green-500 dark:text-green-600' : 'text-red-500 dark:text-red-600' }}">
                                    {{ $category->status }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <div class="space-y-2">
                            <label for="capacity" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Descripción:</label>
                            <div class="px-6 py-4 dark:text-lg">
                                <div style="overflow-wrap: break-word; text-align: justify;"
                                     class="bg-cyan-100 p-2 rounded-sm font-semibold text-center text-lg">
                                    <span>{{ $category->description }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end">
                <button wire:click="$set('openShow', false)"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <div class="flex items-center justify-center p-2 text-gray-200 rounded-md bg-gradient-to-br from-green-300 to-green-500 hover:from-green-500 hover:to-gray-700 hover:text-white transition duration-300 ease-in-out">
            <i class="fas fa-eye"></i>
        </div>
        <div class="absolute z-10 px-3 py-2 text-center text-white bg-gray-800 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"></svg>
        </div>
    </a>

    <!-- Modal de detalle -->
    <x-dialog-modal maxWidth="3xl" wire:model="openShow">
        <div class="w-full mx-auto bg-white dark:bg-gray-800 shadow-md p-6 rounded-md">
            <!-- Título del modal -->
            <x-slot name="title">
                <h2 class="font-semibold text-2xl text-center pt-4 text-gray-500 dark:text-gray-400">Detalle del Proyecto</h2>
            </x-slot>
            <!-- Contenido del modal -->
            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <!-- Categoría y Potencia del Proyecto -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="category_power" class="font-semibold text-gray-700 dark:text-gray-300 text-xl"></label>
                        <p id="category_power" class="text-green-800 dark:text-green-200 text-2xl font-bold p-4 bg-green-200 dark:bg-green-600 rounded-lg shadow-md">
                            {{ $project->projectCategory->name }} de {{ rtrim(rtrim(number_format($project->power_output, 2), '0'), '.') }} kWp
                        </p>
                        <div class="space-y-2">
                            <label for="required_area" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Área Requerida:</label>
                            <p id="required_area" class="text-gray-800 dark:text-gray-200 text-lg">{{ rtrim(rtrim(number_format($project->required_area, 2), '0'), '.') }} mts<sup>2</sup></p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="space-y-2">
                        <label for="status" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Estado:</label>
                        @if ($project->status == 'Activo')
                            <p id="status" class="text-lg py-2 text-green-500 dark:text-green-600">{{ $project->status }}</p>
                        @else
                            <p id="status" class="text-lg py-2 text-red-500 dark:text-red-600">{{ $project->status }}</p>
                        @endif
                    </div>

                    <!-- Zona -->
                    <div class="space-y-2">
                        <label for="zone" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Zona:</label>
                        <p id="zone" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->zone }}</p>
                    </div>

                    <!-- Recursos Asociados -->
                    <div class="space-y-2 md:col-span-2">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Recursos Asociados:</h3>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Mano de Obra -->
                            <div class="space-y-2">
                                <label for="total_labor_cost" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Mano de Obra:</label>
                                <p id="total_labor_cost" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->total_labor_cost }}</p>
                            </div>

                            <!-- Materiales -->
                            <div class="space-y-2">
                                <label for="total_material_cost" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Materiales:</label>
                                <p id="total_material_cost" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->total_material_cost }}</p>
                            </div>

                            <!-- Herramientas -->
                            <div class="space-y-2">
                                <label for="hand_tools" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Herramientas de Mano:</label>
                                <p id="hand_tools" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->hand_tool_cost }}</p>
                            </div>
                            <div class="space-y-2">
                                <label for="standard_tools" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Herramientas Especializada:</label>
                                <p id="standard_tools" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->total_tool_cost }}</p>
                            </div>

                            <!-- Transporte -->
                            <div class="space-y-2">
                                <label for="total_transport_cost" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Transporte:</label>
                                <p id="total_transport_cost" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->total_transport_cost }}</p>
                            </div>

                            <!-- Costos Adicionales -->
                            <div class="space-y-2">
                                <label for="total_additional_cost" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Costos Adicionales:</label>
                                <p id="total_additional_cost" class="text-gray-800 dark:text-gray-200 text-lg">{{ $project->total_additional_cost }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Valor Bruto -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="raw_value" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Valor Bruto:</label>
                        <p id="raw_value" class="text-gray-800 dark:text-gray-200 text-2xl font-bold p-4 bg-gray-100 dark:bg-gray-600 rounded-lg shadow-md">{{ $project->raw_value }}</p>
                    </div>

                    <!-- Valor de Venta -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="sale_value" class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Valor de Venta:</label>
                        <p id="sale_value" class="text-gray-800 dark:text-gray-200 text-2xl font-bold p-4 bg-gray-100 dark:bg-gray-600 rounded-lg shadow-md">{{ $project->sale_value }}</p>
                    </div>
                </div>
            </x-slot>

            <!-- Pie del modal con el botón de cierre -->
            <x-slot name="footer">
                <div class="flex justify-end">
                    <button wire:click="$set('openShow', false)" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition duration-300 ease-in-out flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Cerrar
                    </button>
                </div>
            </x-slot>
        </div>
    </x-dialog-modal>
</div>

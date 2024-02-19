<div class="container mx-auto mt-8">
    @if ($transports->count() > 0)
    <div class="grid items-center w-full md:grid-cols-12 mt-4">
        {{-- Barra de búsqueda --}}
        <div class="col-span-4 ml-4 shadow-md shadow-gray-500 border dark:border-blue-500 rounded-lg">
            <input type="text" name="search" wire:model.live="search"
                class="w-full bg-white dark:text-gray-100 dark:bg-gray-900 border-none rounded-lg focus:ring-blue-400"
                placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Transportes</h1>
            </div>
        </div>
    </div>
    <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
        Resultados
        <select name="perSearch" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-0">
                <div class="overflow-hidden border border-gray-300 dark:border-gray-700 shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-300">
                            <tr>
                                <th data-title="Ordenar por Tipo de Vehículo" wire:click="order('vehicle_type')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Tipo de Vehículo
                                    @if ($sortBy == 'vehicle_type')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Kilometraje Anual" wire:click="order('annual_mileage')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Kilometraje Anual
                                    @if ($sortBy == 'annual_mileage')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Velocidad Promedio" wire:click="order('average_speed')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Velocidad Promedio
                                    @if ($sortBy == 'average_speed')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($transports as $transport)
                            <tr wire:key="transport-list-{{ $transport->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $transport->vehicle_type }}</td>

                                <!-- Agrega aquí las columnas adicionales para mostrar información de los transportes -->

                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <!-- Agrega aquí tus botones de acciones para mostrar, editar y eliminar transportes -->
                                    <livewire:resources.transports.transport-show :transport='$transport'
                                        wire:key='transport-show{{ $transport->id }}' />
                                    <livewire:resources.transports.transport-edit :transportId='$transport->id'
                                        wire:key='transport-edit-{{ $transport->id }}' />
                                    <livewire:resources.transports.transport-delete :transport='$transport'
                                        wire:key='transport-delete-{{ $transport->id }}' />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $transports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mensaje de no hay transportes -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    <div class="flex justify-center w-full h-auto">
        <button
            class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
            <a href="{{ route('transports') }}">Volver</a>
        </button>
    </div>
    @endif

    <!-- Agrega aquí tus scripts JavaScript necesarios -->
    @push('js')
    <script>
        // Agrega aquí tus scripts JavaScript necesarios
        Livewire.on('createdTransportNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Transporte Creado!'
                , text: 'La Transport se ha creado correctamente!'
            })
        });

        Livewire.on('updatedTransportNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Transporte Actualizado!'
                , text: 'La Transport se ha actualizado correctamente!'
            })
        });

        Livewire.on('deletedTransportNotification', function(){
            swal.fire({
                icon: 'success'
                , title: 'Transporte Eliminado!'
                , text: 'La Transport se ha eliminado correctamente!'
            })
        });
    </script>
    @endpush
</div>
<div class="container mx-auto mt-8">
    @if ($labors->count() > 0)
    <div class="grid items-center w-full md:grid-cols-12 mt-4">
        <div class="col-span-4 ml-4 shadow-md shadow-gray-500 border dark:border-blue-500 rounded-lg">
            <input type="text" name="search" wire:model.live="search"
                class="w-full bg-white dark:text-gray-100 dark:bg-gray-900 border-none rounded-lg focus:ring-blue-400"
                placeholder="Buscar..." />
        </div>
        <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Personal</h1>
            </div>
        </div>
        <div class="col-span-4 mt-4 md:mt-0 md:block md:col-span-4">
            <div class="md:text-right">
                <livewire:resources.labors.labor-create />
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
                                <th data-title="Ordenar por ID" wire:click="order('id')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    ID
                                    @if ($sortBy == 'id')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Posición" wire:click="order('position')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Posición
                                    @if ($sortBy == 'position')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Salario Básico" wire:click="order('basic_salary')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Salario Básico
                                    @if ($sortBy == 'basic_salary')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Factor de Beneficio" wire:click="order('benefit_factor')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Factor de Beneficio
                                    @if ($sortBy == 'benefit_factor')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Costo Mensual Real" wire:click="order('real_monthly_cost')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Costo Mensual Real
                                    @if ($sortBy == 'real_monthly_cost')
                                    @if ($sortDirection == 'asc')
                                    <span>&uarr;</span>
                                    @else
                                    <span>&darr;</span>
                                    @endif
                                    @endif
                                </th>

                                <th data-title="Ordenar por Costo Diario Real" wire:click="order('real_daily_cost')"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-400 uppercase">
                                    Costo Diario Real
                                    @if ($sortBy == 'real_daily_cost')
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
                            @foreach ($labors as $labor)
                            <tr wire:key="labor-list-{{ $labor->id }}"
                                class="hover:bg-gray-100 text-gray-500 dark:hover:bg-blue-800">
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->id }}</td>
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->position }}</td>
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->basic }}</td>
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->benefit_factor }}</td>
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->real_monthly_cost }}</td>
                                <td class="px-6 text-left py-4 whitespace-nowrap">{{ $labor->real_daily_cost }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <div class="flex items-center">
                                        <livewire:resources.labors.labor-show :labor='$labor'
                                            wire:key='labor-show{{ $labor->id}}' />
                                        <livewire:resources.labors.labor-edit :laborId='$labor->id'
                                            wire:key='labor-edit-{{ $labor->id}}' />
                                        <livewire:resources.labors.labor-delete :labor='$labor'
                                            wire:key='labor-delete-{{ $labor->id}}' />
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $labors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mensaje de no hay labores -->
    <h1 class="my-64 text-5xl text-center dark:text-gray-200">
        <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
    </h1>
    <div class="flex justify-center w-full h-auto">
        <button
            class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
            <a href="{{ route('labors') }}">Volver</a>
        </button>
    </div>
    @endif
    @push('js')
    <script>
        // Agrega aquí tus scripts JavaScript necesarios
        Livewire.on('createdLaborNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Elemento Creado!'
                , text: 'El elemento se ha creado correctamente!'
            })
        });

        Livewire.on('updatedLaborNotification', function(){
            swal.fire({
                icon:'success'
                , title: 'Elemento Actualizado!'
                , text: 'El elemento se ha actualizado correctamente!'
            })
        });

        Livewire.on('deletedLaborNotification', function(){
            swal.fire({
                icon: 'success'
                , title: 'Elemento Eliminado!'
                , text: 'El elemento se ha eliminado correctamente!'
            })
        });
    </script>
    @endpush
</div>
<div>
    @if ($quotations->count() > 0)
        <div class="grid items-center w-full md:grid-cols-12 mt-2">
            {{-- Barra de búsqueda --}}
            <div class="col-span-4 sm:mx-4">
                <x-input type="text" name="search" wire:model.live="search"
                    class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                    placeholder="Buscar..." />
            </div>
            <div class="inline mt-4 pl-4 pr-24 md:pl-0 md:pr-0 md:mt-0 md:block md:col-span-4">
                <div class="text-xl font-bold text-center text-blue-400 uppercase">
                    <h1>Cotizaciones</h1>
                </div>
            </div>
            <div class="inline mt-4 md:mt-0 md:block md:col-span-4">
                <a href="{{ route('quotation-create') }}">
                    <button
                        class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white">
                        <span
                            class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
                        <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease"><i
                                class="fa fa-solid fa-plus text-xl"></i> Nueva Cotización</span>
                    </button>
                </a>
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
        <div class="relative hidden md:block mt-2 sm:mx-4 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-sm text-center text-gray-100 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('id')">
                            ID
                            @if ($sortBy == 'id')
                                @if ($sortDirection == 'asc')
                                    <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                                @else
                                    <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                                @endif
                            @else
                                <i class="ml-2 fa-solid fa-sort"></i>
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('quotation_date')">
                            Fecha de Cotización
                            @if ($sortBy == 'quotation_date')
                                @if ($sortDirection == 'asc')
                                    <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                                @else
                                    <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                                @endif
                            @else
                                <i class="ml-2 fa-solid fa-sort"></i>
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3 cursor-pointer"
                            wire:click="order('total_quotation_amount')">
                            Monto Total
                            @if ($sortBy == 'total_quotation_amount')
                                @if ($sortDirection == 'asc')
                                    <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                                @else
                                    <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                                @endif
                            @else
                                <i class="ml-2 fa-solid fa-sort"></i>
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quotations as $quotation)
                        <tr
                            class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $quotation->id }}
                            </th>
                            <td class="px-6 py-4 dark:text-lg">{{ $quotation->quotation_date }}</td>
                            <td class="px-6 py-4 dark:text-lg">{{ $quotation->total_quotation_amount }}</td>

                            <td class="flex justify-around py-4 pl-2 pr-8">
                                <div class="flex">
                                    <livewire:quotations.quotation-show :quotation="$quotation" :key="time() . $quotation->id" />
                                    <livewire:quotations.quotation-edit :quotation="$quotation" :key="time() . $quotation->id" />
                                    <livewire:quotations.quotation-delete :quotation="$quotation" :key="time() . $quotation->id" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-3xl text-center dark:text-gray-200">
                                No hay Cotizaciones Disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-3 py-1">
                {{ $quotations->links() }}
            </div>
        </div>
    @else
        <!-- Mensaje de no hay Cotizaciones -->
        <h1 class="my-64 text-5xl text-center dark:text-gray-200">
            <div>¡Ups!</div><br> <span class="mt-4"> No se encontraron coincidencias en la búsqueda. </span>
        </h1>
        <div class="flex justify-center w-full h-auto">
            <livewire:quotations.quotation-create />
            <button
                class="px-8 py-3 mx-auto text-2xl text-blue-500 bg-blue-200 border-2 border-blue-400 rounded-md shadow-md hover:border-blue-500 hover:shadow-blue-400 hover:text-gray-100 hover:bg-blue-300">
                <a href="{{ route('quotations') }}">Volver</a>
            </button>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de cotizaciones
            Livewire.on('createdQuotationNotification', function() {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Creada!',
                    text: 'La cotización se ha creado correctamente!'
                })
            });

            // Notificación de edición de cotizaciones
            Livewire.on('updatedQuotationNotification', function() {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Actualizada!',
                    text: 'La cotización se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de cotizaciones
            Livewire.on('deletedQuotationNotification', function() {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Eliminada!',
                    text: 'La cotización se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

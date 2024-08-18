<div class="container mx-auto mt-8">
    @if ($this->quotations->count() > 0)
        <section class="flex justify-between w-full mx-4">

            {{-- Barra de búsqueda --}}
            <div class="flex justify-start w-1/3">
                <x-input type="text" name="search" wire:model.live="search"
                         class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                         placeholder="Buscar..."/>
            </div>

            {{-- Título --}}
            <div class="flex justify-center w-1/3">
                <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                    <h1>Cotizaciones</h1>
                </div>
            </div>

            {{-- Componente de creación --}}
            <div class="flex justify-end w-1/3 mr-8">
                <livewire:quotations.quotation-create/>
            </div>
        </section>

        {{-- Opciones de visualización --}}
        <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
            Resultados
            <select name="perSearch" id="perSearch" wire:model.live="perSearch" class="rounded-lg cursor-pointer">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>

        <!-- Tabla de Cotizaciones -->
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('consecutive')">
                        Consecutivo
                        @if ($sortBy == 'consecutive')
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
                        Fecha de cotización
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('total')">
                        Precio de Venta
                        @if ($sortBy == 'total')
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
                        Estado
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Descargar
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->quotations as $quotation)
                    <tr wire:key="quotation-{{ $quotation->id }}"
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $quotation->id }}
                        </th>
                        <td class="px-6 py-4 dark:text-lg">{{ $quotation->consecutive }}</td>
                        <td class="px-6 py-4 dark:text-lg">
                            {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 dark:text-lg">{{ number_format($quotation->total, 2) }}</td>
                        <td class="px-6 py-4 dark:text-lg {{ $quotation->status_color }}">
                            {{ $quotation->status }}
                        </td>
                        <td class="px-6 py-4 text-center dark:text-lg">
                            <a href="{{ route('quotations.pdf', $quotation->id) }}"
                               class="flex items-center justify-center text-red-500 hover:text-red-700">
                                <div class="border border-red-500 rounded p-2">
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                </div>
                            </a>
                        </td>
                        <td class="flex justify-around py-4 pl-2 pr-8 ml-6">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:quotations.quotation-show :quotation="$quotation"
                                                                    :key="time() . $quotation->id"/>
                                <livewire:quotations.quotation-edit :quotationId="$quotation->id"
                                                                    :key="time() . $quotation->id"/>
                                <livewire:quotations.quotation-delete :quotation="$quotation"
                                                                      :key="time() . $quotation->id"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-3xl text-center dark:text-gray-200">
                            No hay Cotizaciones Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

            <div class="px-3 py-1">
                {{ $this->quotations->links() }}
            </div>
        </div>
    @else

        <div class="flex justify-end m-4 p-4">
            <livewire:quotations.quotation-create/>
        </div>

        <!-- Mensaje de no hay Cotizaciones -->
        <h2 class="my-32 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h2>

        <div class="flex justify-center w-full h-auto">
            <a href="{{ route('quotations') }}">
                <x-gray-button>
                    Volver
                </x-gray-button>
            </a>
        </div>
    @endif

    @push('js')
        <script>
            // Notificación de creación de cotizaciones
            Livewire.on('createdQuotationNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Creada!',
                    text: 'La cotización se ha creado correctamente!'
                })
            });

            // Notificación de edición de cotizaciones
            Livewire.on('updatedQuotationNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Actualizada!',
                    text: 'La cotización se ha actualizado correctamente!'
                })
            });

            // Notificación de eliminación de cotizaciones
            Livewire.on('deletedQuotationNotification', function () {
                swal.fire({
                    icon: 'success',
                    title: 'Cotización Eliminada!',
                    text: 'La cotización se ha eliminado correctamente!'
                })
            });
        </script>
    @endpush
</div>

<div class="container mx-auto mt-8">
    <section class="flex justify-between w-full mx-4">

        {{-- Barra de búsqueda --}}
        <div class="flex justify-start w-1/3">
            <x-input type="text" name="search" wire:model.live="search"
                     class="w-full bg-white dark:text-gray-100 dark:bg-gray-800 border-none rounded-lg focus:ring-gray-400"
                     placeholder="Buscar por nombre..."/>
        </div>

        {{-- Título --}}
        <div class="flex justify-center w-1/3">
            <div class="text-3xl font-bold text-center text-blue-500 uppercase">
                <h1>Políticas Comerciales</h1>
            </div>
        </div>

        {{-- Componente de creación --}}
        <div class="flex justify-end w-1/3 mr-8">
            <livewire:resources.commercial-policies.commercial-policy-create/>
        </div>
    </section>

    {{-- Opciones de visualización --}}
    <div class="py-2 md:py-4 ml-4 text-gray-500 dark:text-gray-100">
        Resultados
        <select name="perPage" id="perPage" wire:model.live="perPage" class="rounded-lg cursor-pointer">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>

    @if ($this->commercialPolicies->count() > 0)
        <!-- Tabla de Políticas Comerciales -->
        <div class="relative mt-2 sm:mx-4 md:mt-4 overflow-x-hidden shadow-md sm:rounded-lg">
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

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('name')">
                        Nombre
                        @if ($sortBy == 'name')
                            @if ($sortDirection == 'asc')
                                <i class="ml-2 fa-solid fa-arrow-up-z-a"></i>
                            @else
                                <i class="ml-2 fa-solid fa-arrow-down-z-a"></i>
                            @endif
                        @else
                            <i class="ml-2 fa-solid fa-sort"></i>
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="order('percentage')">
                        Porcentaje
                        @if ($sortBy == 'percentage')
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
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->commercialPolicies as $policy)
                    <tr wire:key="policy-{{ $policy->id }}"
                        class="text-center bg-white border-b text-md dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $policy->id }}
                        </th>
                        <td class="px-6 py-4">{{ $policy->name }}</td>
                        <td class="px-6 py-4">{{ $policy->percentage }}%</td>

                        <td class="flex justify-around py-4 pl-2 pr-8 ml-6">
                            <div class="flex justify-center items-center gap-1">
                                <livewire:resources.commercial-policies.commercial-policy-show :commercialPolicy="$policy"
                                                                                     :key="time() . $policy->id"/>
                                <livewire:resources.commercial-policies.commercial-policy-edit :commercialPolicyId="$policy->id"
                                                                                     :key="time() . $policy->id"/>
                                <livewire:resources.commercial-policies.commercial-policy-delete :commercialPolicy="$policy"
                                                                                       :key="time() . $policy->id"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-3xl text-center dark:text-gray-200">
                            No hay Políticas Comerciales Disponibles
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="px-3 py-1">
                {{ $this->commercialPolicies->links() }}  <!-- Paginación -->
            </div>
        </div>
    @else
        <!-- Mensaje de no hay registros -->
        <h1 class="my-64 text-5xl text-center dark:text-gray-200">
            <span class="mt-4"> No hay registros. </span>
        </h1>
    @endif

    @push('js')
        <script>
            // Notificación de creación de políticas comerciales
            Livewire.on('createdCommercialPolicyNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Política Comercial Creada!',
                    text: 'La política comercial se ha creado correctamente!'
                });
            });

            // Notificación de edición de políticas comerciales
            Livewire.on('updatedCommercialPolicyNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Política Comercial Actualizada!',
                    text: 'La política comercial se ha actualizado correctamente!'
                });
            });

            // Notificación de eliminación de políticas comerciales
            Livewire.on('deletedCommercialPolicyNotification', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Política Comercial Eliminada!',
                    text: 'La política comercial se ha eliminado correctamente!'
                });
            });
        </script>
    @endpush
</div>



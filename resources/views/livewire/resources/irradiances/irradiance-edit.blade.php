<div class="container mx-auto mt-6 border border-gray-300 p-6 bg-gray-100 rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Gestor de nivel de irradiancia de municipios</h2>

    <div class="flex flex-row mb-4">
        <div class="w-full mr-2">
            <input wire:model.live="search" type="text"
                   class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Buscar municipio...">
        </div>
    </div>

    <ul class="overflow-y-auto max-h-64 border border-gray-200 rounded-lg bg-white">
        @foreach ($cities as $city)
            <li class="py-3 px-4 hover:bg-gray-200 cursor-pointer"
                wire:click="selectCity({{ $city->id }})">
                {{ $city->name }}
            </li>
        @endforeach
    </ul>

    @if ($selectedCity)
        <div class="mt-6 p-4 bg-white border border-gray-200 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Editar Irradiancia para {{ $selectedCity->name }}</h3>
            <form wire:submit.prevent="updateIrradiance">
                <div class="mb-4">
                    <label for="irradiance" class="block text-gray-600">Irradiancia:</label>
                    <input type="number"
                           wire:model="irradiance"
                           min="0"
                           step="0.01"
                           class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('irradiance')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <x-success-button type="submit" class="my-2">
                    Guardar
                </x-success-button>
            </form>
        </div>
    @endif

    @push('js')
        <script>
            Livewire.on('updatedIrradianceNotification', function (params) {
                const [cityName, updatedIrradiance] = params; // Desempaqueta el array

                Swal.fire({
                    icon: 'success',
                    title: '¡Irradiancia Actualizada!',
                    html: `La irradiancia del municipio de <span style="color: blue; font-weight: bold;">${cityName}</span> se ha actualizado a <span style="color: green; font-weight: bold;">${updatedIrradiance}</span>!`
                });
            });

        </script>
    @endpush

</div>

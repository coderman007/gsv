<div class="container mx-auto mt-6 border border-gray-300 p-6 bg-white rounded-lg shadow-md">
    <!-- Título principal con icono -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-700">
            <i class="fas fa-sun text-yellow-500 mr-2"></i>
            Gestor de nivel de irradiancia
        </h2>
    </div>

    <!-- Imagen decorativa para dar contexto visual -->
    <div class="flex justify-center mb-6">
        <img src="{{asset('images/irradiance.png')}}" alt="Vista de una ciudad" class="rounded-lg shadow-lg w-3/4 h-56" />
    </div>



    <!-- Barra de búsqueda con estilo -->
    <div class="flex flex-row mb-4">
        <div class="w-full">
            <input
                wire:model.live="search"
                type="text"
                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Buscar municipio..."
            />
        </div>
    </div>

    <!-- Lista de ciudades con iconos y resaltado en hover -->
    <ul class="overflow-y-auto max-h-64 border border-gray-200 rounded-lg bg-white">
        @foreach ($cities as $city)
            <li class="py-3 px-4 flex items-center hover:bg-gray-200 cursor-pointer" wire:click="selectCity({{ $city->id }})">
                <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>
                {{ $city->name }}
            </li>
        @endforeach
    </ul>

    <!-- Formulario de edición de irradiancia para la ciudad seleccionada -->
    @if ($selectedCity)
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                <i class="fas fa-edit text-indigo-500 mr-2"></i>
                Editar Irradiancia para {{ $selectedCity->name }}
            </h3>
            <form wire:submit.prevent="updateIrradiance">
                <div class="mb-4">
                    <label for="irradiance" class="block text-gray-600">Irradiancia:</label>
                    <input
                        type="number"
                        wire:model="irradiance"
                        min="0"
                        step="0.01"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    @error('irradiance')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="px-6 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none transition duration-200"
                >
                    Guardar
                </button>
            </form>
        </div>
    @endif

    <!-- Script para notificaciones con SweetAlert -->
    @push('js')
        <script>
            Livewire.on('updatedIrradianceNotification', function (params) {
                const [cityName, updatedIrradiance] = params;
                Swal.fire({
                    icon: 'success',
                    title: '¡Irradiancia Actualizada!',
                    html: `¡La irradiancia del municipio de <span style="color: blue; font-weight: bold;">${cityName}</span> se ha actualizado a <span style="color: green; font-weight: bold;">${updatedIrradiance}</span>!`
                });
            });
        </script>
    @endpush
</div>

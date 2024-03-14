<div>

    <style>
        /* Estilo para reducir el tamaño del título */
        .swal2-title.swal2-title-small {
            font-size: 20px;/
        }
    </style>
    <div>

        <label class="text-md font-semibold text-gray-600 py-2">País</label>
        <!-- Dropdown para País -->
        @if (!is_null($countries))
            <select wire:model.live="selectedCountry"
                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Seleccione un país</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <x-input-error for="country" />
        @endif
        <label class="text-md font-semibold text-gray-600 py-2">Departamento</label>
        <!-- Dropdown para Departamento -->
        @if (!is_null($departments))
            <select wire:model.live="selectedDepartment"
                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Seleccione un departamento</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <x-input-error for="department" />
        @endif
        <label class="text-md font-semibold text-gray-600 py-2">Ciudad</label>
        <!-- Dropdown para Ciudad -->
        @if (!is_null($cities))
            <select wire:model.live="selectedCity"
                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Seleccione una ciudad</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            <x-input-error for="city" />
        @endif

        <!-- Campo de Dirección -->
        @if (!is_null($selectedCity))
            <div>
                <label for="location" class="text-sm font-semibold text-blue-500 py-2">Dirección</label>
                <input wire:model="address" type="text"
                    class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Dirección">
                <x-input-error for="location" />
            </div>
        @endif

        @push('js')
            <script>
                // Notificación de Ubicación Almacenada
                Livewire.on('locationStored', function() {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: 'Ubicación Almacenada con éxito!',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            title: 'swal2-title-small',
                        }
                    });
                });
            </script>
        @endpush
    </div>

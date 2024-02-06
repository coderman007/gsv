<div>
    <div class="max-w-md mx-auto bg-white shadow-md p-6 rounded-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Seleccione una ubicación</h2>

        <div>
            <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País:</label>
            <select wire:model.live="selectedCountry"
                class="block w-full p-2 mb-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Selecciona un país</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <x-input-error for="country" />
        </div>

        @if(!is_null($departments))
        <div>
            <label for="department"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento:</label>
            <select wire:model.live="selectedDepartment"
                class="bg-gray-50 border border-gray-300 text-gray-900 mb-4 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Selecciona un departamento</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <x-input-error for="department" />
        </div>
        @endif

        @if(!is_null($cities))
        <div>
            <label for="city" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Ciudad:</label>
            <select wire:model.live="selectedCity"
                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" disabled selected>Selecciona una ciudad</option>
                @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            <x-input-error for="city" />
        </div>
        @endif

        @if (!is_null($selectedCity))
        <div>
            <label for="location"
                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Dirección:</label>
            <input wire:model="address" type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Dirección">
        </div>
        <x-input-error for="location" />
        @endif

        <div class="mt-6">
            <button wire:click="saveLocation"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Guardar</button>
        </div>
    </div>
</div>
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">COTIZACIONES SISTEMAS FOTOVOLTAICOS</h1>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Información del cliente:</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input id="nombre" wire:model="nombre" type="text" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="Correo Electrónico" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
                <input id="email" wire:model="email" type="email" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Dirección:</label>
                <input id="address" wire:model="address" type="text" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono:</label>
                <input id="phone" wire:model="phone" type="text" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Consumo mensual de energía:</h2>
        <input id="consumoMensual" wire:model="consumoMensual" type="number" class="p-2 border border-gray-300">
    </div>

    <!-- Resto del contenido... -->

    <div class="mb-8" x-data="{ open: false }">
        <button @click="open = !open" class="bg-blue-500 text-white py-2 px-4 rounded">Calcular</button>

        <div x-show="open" class="mt-4">
            <h2 class="text-xl font-semibold mb-2">Resultados:</h2>
            <!-- Mostrar resultados calculados aquí -->
        </div>
    </div>
</div>

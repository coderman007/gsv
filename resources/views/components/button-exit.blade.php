<button
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 px-6 py-3 text-gray-800 bg-gray-300 border border-gray-500
         rounded-md shadow-md hover:bg-gray-400 focus:outline-none text-lg
         font-semibold'
    ]) }}
    wire:click="{{ $clickAction ?? '' }}">
    <i class="fa-solid fa-ban"></i> <!-- Icono para "Salir" -->
    {{ $slot }}
</button>



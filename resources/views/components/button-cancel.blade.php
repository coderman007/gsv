<button
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 px-6 py-3 text-gray-500 border border-gray-500 rounded-md
         shadow-md hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 text-lg
         font-semibold'
    ]) }}
    wire:click="{{ $clickAction ?? '' }}">
    <i class="fas fa-times-circle text-lg"></i> <!-- Icono para "Cancelar" -->
    {{ $slot }}
</button>


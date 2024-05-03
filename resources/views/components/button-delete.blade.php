<button
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 px-6 py-3 text-red-500 border border-red-500 rounded-md
         shadow-md hover:bg-red-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 text-lg
         font-semibold'
    ]) }}
    wire:click="{{ $clickAction ?? '' }}">
    <i class="fas fa-trash-alt text-lg"></i> <!-- Icono para "Eliminar" -->
    {{ $slot }}
</button>


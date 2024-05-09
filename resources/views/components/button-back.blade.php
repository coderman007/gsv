<button onclick="window.history.back()"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 px-6 py-3 text-white bg-blue-500 border border-blue-800 rounded-md
        shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 text-lg font-semibold'
    ]) }}>
    <i class="fas fa-arrow-left"></i> <!-- Icono para "Volver" -->
    {{ $slot ?? 'Volver' }}
</button>


<button {{ $attributes->merge(['type' => 'button', 'class' => 'rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-gray-500 hover:border-blue-500 text-white']) }}>
    <span
        class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-blue-500 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease">
    </span>
    <span class="relative text-gray-500 transition duration-700 group-hover:text-white ease">
        <i
            class="fa fa-solid fa-edit text-xl">
        </i> Editar
    </span>
    {{ $slot }}
</button>

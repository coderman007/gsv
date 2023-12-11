<div class="flex justify-between">
    <div class="bg-[#70A02A] rounded-full">
        <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" width="50" class="rounded-full shadow-white-2xl brightness-90 hover:brightness-150 transition duration-700 ease-in-out" alt="Logo JStock">
        </a>
    </div>
</div>

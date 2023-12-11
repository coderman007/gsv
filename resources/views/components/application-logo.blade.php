<div>
    @if (auth()->check())
    <div class="flex justify-between">
        <div class="bg-[#70A02A] rounded-full">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" width="50" class="transition duration-700 ease-in-out rounded-full shadow-white-2xl brightness-90 hover:brightness-150" alt="Logo GSV">
            </a>
        </div>

    </div>
    @else
    <div class="flex justify-between">
        <div class="bg-[#70A02A] rounded-full">
            <a href="{{ route('welcome') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" width="50" class="transition duration-700 ease-in-out rounded-full shadow-white-2xl brightness-90 hover:brightness-150" alt="Logo JStock">
            </a>
        </div>

        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-gray-400"><a href="{{ route('welcome') }}"><span class="ml-4 text-[#70A02A]">Quick</span>Quote</a></span>

    </div>
    @endif
</div>

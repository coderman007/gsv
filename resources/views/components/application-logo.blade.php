<div>
    @if (auth()->check())
    <div class="flex justify-between">
        <div class="rounded flex bg-white items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <img src="{{ asset('images/logo.jpg') }}" width="50"
                     class="transition duration-700 ease-in-out rounded-full shadow-white-2xl brightness-90 hover:brightness-150"
                     alt="Logo GSV">
            </a>
            <div class="slogan text-center ml-1">
                <div class="">
                    <h1 class="my-[-3px] text-[13px]">
                        <span class="text-sm font-extrabold">G</span>estión energética y
                    </h1>
                    <h1 class="my-[-3px] text-[13px]">
                        <span class="text-sm font-extrabold">S</span>oluciones <span class="text-sm font-extrabold">V</span>erdes
                    </h1>
                </div>
                <div class="">
                    <h1 class="my-[-3px] text-[9px]">con ingeniería</h1>
                </div>
            </div>
        </div>

    </div>
    @else
    <div class="flex justify-between">
        <div class="bg-[#70A02A] rounded-full">
            <a href="{{ route('welcome') }}" class="flex items-center">
                <img src="{{ asset('images/n_logo.png') }}" width="50" class="transition duration-700 ease-in-out rounded-full shadow-white-2xl brightness-90 hover:brightness-150" alt="Logo JStock">
            </a>
        </div>

        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-gray-400"><a href="{{ route('welcome') }}"><span class="ml-4 text-[#70A02A]">Quick</span>Quote</a></span>

    </div>
    @endif
</div>

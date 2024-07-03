<div class="">

    <div class="rounded flex items-center">
        <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}" class="flex rounded-lg bg-transparent items-center">
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

<div class="flex flex-col items-center min-h-screen pt-6 bg-gray-200 dark:bg-gray-700 sm:justify-center sm:pt-0">

    @if(session('error_message'))
    <div class="bg-red-200 border-t-4 w-3/4 mb-10 border-red-600 rounded-b text-gray-600 px-4 py-3 shadow-md" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-600 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" /></svg></div>
            <div>
                <p class="font-bold text-3xl text-gray-600">¡Lo sentimos!</p>
                <strong>
                    <p class="text-2xl">{{session('error_message')}}</p>
                </strong>
            </div>
        </div>
    </div>

    @endif

    <div>
        {{ $logo }}
    </div>

    <div class="w-full">
        {{ $slot }}
    </div>
</div>

<nav x-data="{ open: false }" class="bg-gray-200 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700">
    <div class="mx-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex text-blue-200">
                    <x-nav-link :href="auth()->check() ? route('dashboard') : route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('help') }}" :active="request()->routeIs('help')">
                        {{ __('Ayuda') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('manual') }}" :active="request()->routeIs('manual')">
                        {{ __('Manual de Usuario') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('settings') }}" :active="request()->routeIs('settings')">
                        {{ __('Configuración') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3">
                    <x-nav-link href="{{ route('login') }}" class="btn-primary">
                        {{ __('Iniciar Sesión') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden dark:bg-gray-800 dark:border-gray-700">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/" :active="request()->routeIs('welcome')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('help') }}" :active="request()->routeIs('help')">
                {{ __('Ayuda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manual') }}" :active="request()->routeIs('manual')">
                {{ __('Manual de usuario') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('settings') }}" :active="request()->routeIs('settings')">
                {{ __('Configuración') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('login') }}" class="btn-primary">
                {{ __('Iniciar Sesión') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>

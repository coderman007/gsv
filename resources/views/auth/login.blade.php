<x-guest-layout>
    <x-authentication-card class="dark:bg-gray-800">
        <x-slot name="logo">
            <div class="flex">
                <x-authentication-card-logo />
                <p class="mt-4 ml-4 text-5xl font-bold text-center text-gray-700 dark:text-gray-300">
                    <!-- Contenido opcional del logo en modo oscuro -->
                </p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
        @endif

        <div class="relative w-5/6 py-3 mx-auto md:w-4/5 lg:w-1/3 2xl:w-1/4">
            <div class="relative px-6 py-10 bg-gray-600 dark:bg-gray-800 to-gray-600 dark:shadow-2xl rounded-3xl">
                <div class="max-w-md mx-auto">
                    <div>
                        <h1 class="mb-4 text-3xl text-center text-gray-200 dark:text-gray-200">Ingresar</h1>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <x-label for="email" value="{{ __('Email') }}" class="text-gray-200 dark:text-gray-200" />
                            <x-input id="email" class="block w-full mt-1" type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username" />
                        </div>
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}"
                                class="text-gray-200 dark:text-gray-200" />
                            <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>
                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-200 dark:text-gray-400 dark:hover:text-gray-100">{{
                                    __('Recuérdame') }}</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-around mt-4">
                            @if (Route::has('password.request'))
                            <div class="flex flex-col text-center">
                                <a class="text-sm text-gray-200 underline rounded-md dark:text-gray-400 hover:text-white dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>

                                <a class="text-sm text-gray-200 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    href="{{ route('register') }}">
                                    {{ __('¿Aún no tienes una cuenta?') }}
                                </a>
                            </div>
                            @endif
                            <div>
                                <x-button
                                    class="ml-4 bg-blue-500 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-300 dark:text-gray-700 dark:font-bold dark:hover:text-gray-900">
                                    {{ __('Acceder') }}
                                </x-button>


                            </div>
                        </div>
                    </form>
                    <hr class="mt-2">
                    {{--
                    <x-sn-icons /> --}}
                </div>
            </div>
        </div>

        <div class="space-y-4 text-center text-gray-700 dark:text-gray-200 mt-14 sm:-mb-8">
            <p class="text-md">Al acceder, aceptas los <a href="#" class="underline">términos y condiciones</a> de
                nuestro sitio.</p>

            <p>Aplican los <a href="https://google.com/" class="underline"> términos de servicio de Google</a>.</p>
        </div>
    </x-authentication-card>
</x-guest-layout>
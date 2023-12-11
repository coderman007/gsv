<!-- component -->
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex">
                <x-authentication-card-logo />
                <p class="mt-4 ml-4 text-5xl font-bold text-center text-gray-700 dark:text-gray-300">
                </p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <div class="relative w-5/6 py-3 mx-auto md:w-4/5 lg:w-1/3 2xl:w-1/4">
            <div class="relative px-6 py-10 bg-gradient-to-r from-gray-400 to-gray-600 dark:shadow-2xl rounded-3xl">
                <div class="max-w-md mx-auto">
                    <div>
                        <h1 class="mb-4 text-3xl text-center text-gray-200">Registro</h1>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div>
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                            <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Contraseña') }}" />
                            <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                            <x-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                                    route('terms.show') .
                                                    '" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                                    route('policy.show') .
                                                    '" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                        @endif

                        <div class="flex items-center justify-center mt-4">
                            <a class="text-sm text-gray-200 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                {{ __('¿Ya estás registrado?') }}
                            </a>

                            <x-button class="ml-4 bg-gray-600 hover:bg-gray-700">
                                {{ __('Registrarse') }}
                            </x-button>
                        </div>
                    </form>
                    <hr class=" mt-2">
                    <x-sn-icons />
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-gray-700 md:mt-14">
            <p class="text-md">Al acceder, aceptas los <a href="#" class="underline">términos y condiciones</a> de
                nuestro sitio.</p>

            <p>Aplican los <a href="https://google.com/" class="underline"> términos de servicio de Google</a>.</p>
        </div>

    </x-authentication-card>
</x-guest-layout>

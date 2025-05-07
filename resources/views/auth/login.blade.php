<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center justify-center py-12">
        <div class="w-full sm:max-w-md px-6 py-4 bg-gray-800/0 overflow-hidden sm:rounded-2xl">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-white">Вход в систему</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-100/70" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Пароль')" class="text-gray-100/70" />

                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700/50 border-0 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-0 text-indigo-600 shadow-sm focus:ring-indigo-500 bg-gray-700/50" name="remember">
                        <span class="ms-2 text-sm text-gray-300">{{ __('Запомнить меня') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-300 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Забыли пароль?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-lg">
                        {{ __('Войти') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

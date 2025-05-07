<x-guest-layout>
    <div class="flex flex-col items-center justify-center py-12">
        <div class="w-full sm:max-w-md px-6 py-4 bg-gray-800/0 overflow-hidden sm:rounded-2xl">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-white">Регистрация</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" x-data="{ showInstrument: {{ old('role') == 'musician' ? 'true' : 'false' }} }">
                @csrf

                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('Имя')" class="text-gray-100/70" />
                    <x-text-input id="first_name" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Фамилия')" class="text-gray-100/70" />
                    <x-text-input id="last_name" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg" type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-100/70" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Пароль')" class="text-gray-100/70" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" class="text-gray-100/70" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 rounded-lg"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <x-input-label :value="__('Выберите роль')" class="text-gray-100/70" />
                    <div class="mt-2 space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="user" {{ old('role') == 'user' ? 'checked' : '' }} class="rounded border-0 text-indigo-600 shadow-sm focus:ring-indigo-500 bg-gray-700/50" x-on:click="showInstrument = false">
                            <span class="ml-2 text-gray-300">Пользователь</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="role" value="musician" {{ old('role') == 'musician' ? 'checked' : '' }} class="rounded border-0 text-indigo-600 shadow-sm focus:ring-indigo-500 bg-gray-700/50" x-on:click="showInstrument = true">
                            <span class="ml-2 text-gray-300">Музыкант</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="mt-4" x-show="showInstrument" x-transition>
                    <x-input-label for="instrument" :value="__('Инструмент')" class="text-gray-100/70" />
                    <select id="instrument" name="instrument" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">Выберите инструмент</option>
                        <option value="piano" {{ old('instrument') == 'piano' ? 'selected' : '' }}>Пианино</option>
                        <option value="guitar" {{ old('instrument') == 'guitar' ? 'selected' : '' }}>Гитара</option>
                        <option value="violin" {{ old('instrument') == 'violin' ? 'selected' : '' }}>Скрипка</option>
                        <option value="drums" {{ old('instrument') == 'drums' ? 'selected' : '' }}>Ударные</option>
                        <option value="saxophone" {{ old('instrument') == 'saxophone' ? 'selected' : '' }}>Саксофон</option>
                        <option value="flute" {{ old('instrument') == 'flute' ? 'selected' : '' }}>Флейта</option>
                        <option value="cello" {{ old('instrument') == 'cello' ? 'selected' : '' }}>Виолончель</option>
                        <option value="trumpet" {{ old('instrument') == 'trumpet' ? 'selected' : '' }}>Труба</option>
                        <option value="bass" {{ old('instrument') == 'bass' ? 'selected' : '' }}>Бас-гитара</option>
                        <option value="accordion" {{ old('instrument') == 'accordion' ? 'selected' : '' }}>Аккордеон</option>
                    </select>
                    <x-input-error :messages="$errors->get('instrument')" class="mt-2" />
                </div>

                <!-- About Musician -->
                <div class="mt-4" x-show="showInstrument" x-transition>
                    <x-input-label for="about" :value="__('О музыканте')" class="text-gray-100/70" />
                    <textarea id="about" name="about" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Расскажите о себе...">{{ old('about') }}</textarea>
                    <x-input-error :messages="$errors->get('about')" class="mt-2" />
                </div>

                <!-- Experience -->
                <div class="mt-4" x-show="showInstrument" x-transition>
                    <x-input-label for="experience" :value="__('Опыт')" class="text-gray-100/70" />
                    <textarea id="experience" name="experience" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Опишите ваш опыт работы...">{{ old('experience') }}</textarea>
                    <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                </div>

                <!-- Skills -->
                <div class="mt-4" x-show="showInstrument" x-transition>
                    <x-input-label for="skills" :value="__('Навыки')" class="text-gray-100/70" />
                    <textarea id="skills" name="skills" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Перечислите ваши навыки...">{{ old('skills') }}</textarea>
                    <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                </div>

                <!-- Education -->
                <div class="mt-4" x-show="showInstrument" x-transition>
                    <x-input-label for="education" :value="__('Образование')" class="text-gray-100/70" />
                    <textarea id="education" name="education" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Опишите ваше образование...">{{ old('education') }}</textarea>
                    <x-input-error :messages="$errors->get('education')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-300 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Уже зарегистрированы?') }}
                    </a>

                    <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-lg">
                        {{ __('Зарегистрироваться') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white">
                                {{ __('Информация профиля') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-400">
                                {{ __("Обновите информацию вашего профиля и адрес электронной почты.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="flex items-center gap-4">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                                <div>
                                    <input type="file" name="avatar" class="block w-full text-sm text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-600 file:text-white
                                        hover:file:bg-blue-700">
                                </div>
                            </div>

                            <div>
                                <x-input-label for="name" :value="__('Имя')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800">
                                            {{ __('Your email address is unverified.') }}

                                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($user->role === 'musician')
                                <div>
                                    <x-input-label for="instrument" :value="__('Инструмент')" />
                                    <select id="instrument" name="instrument" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Выберите инструмент</option>
                                        <option value="piano" {{ old('instrument', $user->instrument) == 'piano' ? 'selected' : '' }}>Пианино</option>
                                        <option value="guitar" {{ old('instrument', $user->instrument) == 'guitar' ? 'selected' : '' }}>Гитара</option>
                                        <option value="violin" {{ old('instrument', $user->instrument) == 'violin' ? 'selected' : '' }}>Скрипка</option>
                                        <option value="drums" {{ old('instrument', $user->instrument) == 'drums' ? 'selected' : '' }}>Ударные</option>
                                        <option value="saxophone" {{ old('instrument', $user->instrument) == 'saxophone' ? 'selected' : '' }}>Саксофон</option>
                                        <option value="flute" {{ old('instrument', $user->instrument) == 'flute' ? 'selected' : '' }}>Флейта</option>
                                        <option value="cello" {{ old('instrument', $user->instrument) == 'cello' ? 'selected' : '' }}>Виолончель</option>
                                        <option value="trumpet" {{ old('instrument', $user->instrument) == 'trumpet' ? 'selected' : '' }}>Труба</option>
                                        <option value="bass" {{ old('instrument', $user->instrument) == 'bass' ? 'selected' : '' }}>Бас-гитара</option>
                                        <option value="accordion" {{ old('instrument', $user->instrument) == 'accordion' ? 'selected' : '' }}>Аккордеон</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('instrument')" />
                                </div>

                                <div>
                                    <x-input-label for="about" :value="__('О музыканте')" />
                                    <textarea id="about" name="about" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Расскажите о себе...">{{ old('about', $user->about) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('about')" />
                                </div>

                                <div>
                                    <x-input-label for="experience" :value="__('Опыт')" />
                                    <textarea id="experience" name="experience" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Опишите ваш опыт работы...">{{ old('experience', $user->experience) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('experience')" />
                                </div>

                                <div>
                                    <x-input-label for="skills" :value="__('Навыки')" />
                                    <textarea id="skills" name="skills" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Перечислите ваши навыки...">{{ old('skills', $user->skills) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                                </div>

                                <div>
                                    <x-input-label for="education" :value="__('Образование')" />
                                    <textarea id="education" name="education" rows="3" class="mt-1 block w-full rounded-lg bg-gray-700/50 border-0 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" placeholder="Опишите ваше образование...">{{ old('education', $user->education) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('education')" />
                                </div>
                            @endif

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-400"
                                    >{{ __('Сохранено.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-white">
                                {{ __('Удалить аккаунт') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-400">
                                {{ __('После удаления вашего аккаунта все его ресурсы и данные будут безвозвратно удалены.') }}
                            </p>
                        </header>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >{{ __('Удалить аккаунт') }}</x-danger-button>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-white">
                                    {{ __('Вы уверены, что хотите удалить свой аккаунт?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-400">
                                    {{ __('Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свой аккаунт.') }}
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="password" value="{{ __('Пароль') }}" class="sr-only" />

                                    <x-text-input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="mt-1 block w-3/4"
                                        placeholder="{{ __('Пароль') }}"
                                    />

                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Отмена') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Удалить аккаунт') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Обложка профиля с параллакс-эффектом -->
        <div class="relative h-64 overflow-hidden" x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.pageYOffset">
            @if($musician->cover_url)
                <img src="{{ $musician->cover_url }}" alt="Обложка профиля" 
                    class="w-full h-full object-cover transform transition-transform duration-300"
                    :style="'transform: translateY(' + scrollY * 0.5 + 'px)'">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>
        </div>

        <!-- Основная информация -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10 pb-12">
            <!-- Профиль -->
            <div class="bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start gap-6">
                        <!-- Аватар с анимацией при наведении -->
                        <div class="relative flex-shrink-0 group">
                            <div class="w-32 h-32 rounded-full border-4 border-indigo-500 shadow-lg overflow-hidden transform transition-all duration-300 group-hover:scale-105">
                                <img src="{{ $musician->getAvatarUrlAttribute() }}" alt="{{ $musician->name }}" 
                                    class="w-full h-full object-cover bg-gray-700">
                            </div>
                            @if($musician->is_verified)
                                <div class="absolute -top-2 -right-2 bg-indigo-500 rounded-full p-2 animate-pulse">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Информация о музыканте -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white mb-3">{{ $musician->name }}</h1>
                            <div class="flex flex-wrap items-center gap-3 text-gray-300 mb-4">
                                <span class="flex items-center bg-gray-700/50 px-3 py-1.5 rounded-full text-sm">
                                    <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ $musician->instrument }}
                                </span>
                                @if($musician->city)
                                    <span class="flex items-center bg-gray-700/50 px-3 py-1.5 rounded-full text-sm">
                                        <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $musician->city }}
                                    </span>
                                @endif
                                @if($musician->age)
                                    <span class="flex items-center bg-gray-700/50 px-3 py-1.5 rounded-full text-sm">
                                        <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $musician->age }} лет
                                    </span>
                                @endif
                            </div>

                            <!-- Кнопки действий -->
                            @auth
                                @if(auth()->id() !== $musician->id)
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('bookings.create', ['musician_id' => $musician->id]) }}" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Забронировать
                                        </a>
                                        <a href="{{ route('chat.index', $musician->id) }}" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-purple-600 hover:bg-purple-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            Написать
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Информационные плитки -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <!-- О музыканте -->
                    <div class="bg-gray-700/70 rounded-full p-6 backdrop-blur-sm transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-white ml-3">О музыканте</h2>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed">{{ $musician->about ?? 'Нет описания' }}</p>
                    </div>

                    <!-- Образование -->
                    <div class="bg-gray-700/30 rounded-full p-6 backdrop-blur-sm transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-white ml-3">Образование</h2>
                        </div>
                        <p class="text-gray-300 text-sm">{{ $musician->education ?? 'Не указано' }}</p>
                    </div>

                    <!-- Опыт -->
                    <div class="bg-gray-700/30 rounded-full p-6 backdrop-blur-sm transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-white ml-3">Опыт</h2>
                        </div>
                        <p class="text-gray-300 text-sm">{{ $musician->experience ?? 'Не указано' }}</p>
                    </div>

                    <!-- Навыки -->
                    <div class="bg-gray-700/30 rounded-full p-6 backdrop-blur-sm transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-white ml-3">Навыки</h2>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if($musician->skills)
                                @foreach(explode(',', $musician->skills) as $skill)
                                    <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm">{{ trim($skill) }}</span>
                                @endforeach
                            @else
                                <p class="text-gray-300 text-sm">Не указано</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rating', () => ({
                rating: 0
            }))
        })
    </script>
    @endpush
</x-app-layout> 
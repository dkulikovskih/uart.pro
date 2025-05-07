<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-white mb-6">Поиск музыкантов</h2>

                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('musicians.index') }}" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="instrument" class="block text-sm font-medium text-gray-300">Инструмент</label>
                                <select name="instrument" id="instrument" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                                    <option value="">Все инструменты</option>
                                    @foreach($instruments as $value => $label)
                                        <option value="{{ $value }}" {{ request('instrument') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="education" class="block text-sm font-medium text-gray-300">Образование</label>
                                <select name="education" id="education" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                                    <option value="">Любое образование</option>
                                    @foreach($educationLevels as $value => $label)
                                        <option value="{{ $value }}" {{ request('education') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-300">Город</label>
                                <input type="text" name="city" id="city" value="{{ request('city') }}"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white"
                                    placeholder="Введите город">
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-300">Пол</label>
                                <select name="gender" id="gender" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                                    <option value="">Любой пол</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Мужской</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Женский</option>
                                </select>
                            </div>

                            <div>
                                <label for="min_age" class="block text-sm font-medium text-gray-300">Минимальный возраст</label>
                                <input type="number" name="min_age" id="min_age" value="{{ request('min_age') }}"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white"
                                    min="18" max="100">
                            </div>

                            <div>
                                <label for="max_age" class="block text-sm font-medium text-gray-300">Максимальный возраст</label>
                                <input type="number" name="max_age" id="max_age" value="{{ request('max_age') }}"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white"
                                    min="18" max="100">
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Применить фильтры
                            </button>
                        </div>
                    </form>

                    <!-- Список музыкантов -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($musicians as $musician)
                            <a href="{{ route('musicians.show', $musician) }}" class="block">
                                <div class="bg-gray-700 rounded-lg overflow-hidden shadow-lg transform transition duration-300 hover:scale-105">
                                    <div class="relative">
                                        <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                            <img src="{{ $musician->avatar_url }}" alt="{{ $musician->name }}" 
                                                class="w-32 h-32 rounded-full border-4 border-gray-700 object-cover shadow-lg">
                                        </div>
                                    </div>
                                    
                                    <div class="pt-20 pb-6 px-6">
                                        <div class="text-center">
                                            <h3 class="text-xl font-bold text-white">{{ $musician->name }}</h3>
                                            <p class="text-blue-400 font-medium mt-1">{{ $musician->instrument }}</p>
                                        </div>
                                        
                                        <div class="mt-6 space-y-3">
                                            @if($musician->education_level)
                                                <div class="flex items-center text-gray-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                    </svg>
                                                    <span class="text-sm">{{ $educationLevels[$musician->education_level] ?? $musician->education_level }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($musician->city)
                                                <div class="flex items-center text-gray-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    <span class="text-sm">{{ $musician->city }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($musician->age)
                                                <div class="flex items-center text-gray-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-sm">{{ $musician->age }} лет</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if($musician->bio)
                                            <p class="mt-4 text-sm text-gray-300 text-center italic">"{{ Str::limit($musician->bio, 100) }}"</p>
                                        @endif

                                        <div class="mt-6 text-center">
                                            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-md font-semibold text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Забронировать
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-6">
                        {{ $musicians->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
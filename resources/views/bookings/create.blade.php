<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-white mb-4">Бронирование музыканта</h2>
                        
                        <!-- Информация о музыканте -->
                        <div class="flex items-center space-x-4 bg-gray-700 p-4 rounded-lg">
                            <img src="{{ $musician->avatar_url }}" alt="{{ $musician->name }}" class="w-20 h-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-xl font-semibold text-white">{{ $musician->name }}</h3>
                                <p class="text-blue-400">{{ $musician->instrument }}</p>
                                @if($musician->city)
                                    <p class="text-gray-300 text-sm">{{ $musician->city }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="musician_id" value="{{ $musician->id }}">

                        <!-- Дата -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-300">Дата</label>
                            <input type="date" name="date" id="date" required
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                            @error('date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Время -->
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-300">Время</label>
                            <select name="time" id="time" required
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                                @foreach($timeSlots as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('time')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Длительность -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-300">Длительность (часы)</label>
                            <input type="number" name="duration" id="duration" min="1" max="8" value="1" required
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                            @error('duration')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Место проведения -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-300">Место проведения</label>
                            <input type="text" name="location" id="location" required
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Укажите адрес или место проведения">
                            @error('location')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Описание -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300">Описание мероприятия</label>
                            <textarea name="description" id="description" rows="3" required
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Опишите ваше мероприятие, пожелания к музыке и другие детали"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-md hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                Отправить заявку
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
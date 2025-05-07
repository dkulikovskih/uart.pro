<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-white mb-6">
                        {{ auth()->user()->isMusician() ? 'Мои выступления' : 'Мои заказы' }}
                    </h2>

                    @if($bookings->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-400 text-lg">
                                {{ auth()->user()->isMusician() ? 'У вас пока нет запланированных выступлений' : 'У вас пока нет заказов' }}
                            </p>
                            @if(!auth()->user()->isMusician())
                                <a href="{{ route('musicians.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Найти музыканта
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($bookings as $booking)
                                <div class="bg-gray-700 rounded-lg p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium text-white">
                                                {{ auth()->user()->isMusician() ? $booking->user->name : $booking->musician->name }}
                                            </h3>
                                            <p class="text-gray-400 mt-1">
                                                {{ $booking->start_time->format('d.m.Y H:i') }} - {{ $booking->end_time->format('H:i') }}
                                            </p>
                                            <p class="text-gray-400">
                                                Длительность: {{ $booking->start_time->diffInHours($booking->end_time) }} {{ trans_choice('час|часа|часов', $booking->start_time->diffInHours($booking->end_time)) }}
                                            </p>
                                            @if($booking->description)
                                                <p class="text-gray-400 mt-2">{{ $booking->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($booking->status === 'pending') bg-yellow-500 text-yellow-900
                                                @elseif($booking->status === 'confirmed') bg-green-500 text-green-900
                                                @else bg-red-500 text-red-900
                                                @endif">
                                                @if($booking->status === 'pending') Ожидает подтверждения
                                                @elseif($booking->status === 'confirmed') Подтверждено
                                                @else Отменено
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-end space-x-3">
                                        <a href="{{ route('bookings.show', $booking) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Подробнее
                                        </a>

                                        @if($booking->status === 'pending')
                                            @if(auth()->user()->isMusician())
                                                <form action="{{ route('bookings.confirm', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Подтвердить
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Отменить
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
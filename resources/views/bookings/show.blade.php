<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-white mb-6">Детали бронирования</h2>

                    <!-- Статус бронирования -->
                    <div class="mb-8">
                        <div class="inline-flex items-center px-4 py-2 rounded-full 
                            @if($booking->status === 'pending') bg-yellow-600
                            @elseif($booking->status === 'confirmed') bg-green-600
                            @elseif($booking->status === 'cancelled') bg-red-600
                            @endif">
                            <span class="text-white font-medium">
                                @if($booking->status === 'pending') Ожидает подтверждения
                                @elseif($booking->status === 'confirmed') Подтверждено
                                @elseif($booking->status === 'cancelled') Отменено
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Информация о музыканте -->
                    <div class="bg-gray-700 rounded-lg p-6 mb-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $booking->musician->avatar_url }}" alt="{{ $booking->musician->name }}" 
                                class="w-20 h-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-xl font-semibold text-white">{{ $booking->musician->name }}</h3>
                                <p class="text-blue-400">{{ $booking->musician->instrument }}</p>
                                @if($booking->musician->city)
                                    <p class="text-gray-300 text-sm">{{ $booking->musician->city }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Детали бронирования -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Дата</h4>
                                <p class="text-white">{{ $booking->start_time->format('d.m.Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Время начала</h4>
                                <p class="text-white">{{ $booking->start_time->format('H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Время окончания</h4>
                                <p class="text-white">{{ $booking->end_time->format('H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Длительность</h4>
                                <p class="text-white">{{ $booking->start_time->diffInHours($booking->end_time) }} {{ trans_choice('час|часа|часов', $booking->start_time->diffInHours($booking->end_time)) }}</p>
                            </div>
                        </div>

                        @if($booking->description)
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Примечания</h4>
                                <p class="text-white mt-1">{{ $booking->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Кнопки действий -->
                    <div class="mt-8 flex justify-end space-x-4">
                        @if($booking->status === 'pending')
                            @if(auth()->id() === $booking->musician_id)
                                <form method="POST" action="{{ route('bookings.confirm', $booking) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                        Подтвердить
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Отменить
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Чат -->
                    <div class="mt-8 bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4 border-b border-gray-700">
                            <h3 class="text-lg font-semibold text-white">Обсуждение заказа</h3>
                        </div>
                        
                        <div class="h-96 overflow-y-auto p-4" id="messages">
                            <!-- Сообщения будут добавлены через JavaScript -->
                        </div>

                        <div class="p-4 border-t border-gray-700">
                            <form id="message-form" class="flex gap-2">
                                <input type="text" name="content" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="Введите сообщение...">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Отправить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages');
            const messageForm = document.getElementById('message-form');
            const bookingId = {{ $booking->id }};

            // Подключение к WebSocket
            Echo.private(`booking.${bookingId}`)
                .listen('NewMessage', (e) => {
                    appendMessage(e.message);
                });

            // Загрузка истории сообщений
            fetch(`/bookings/${bookingId}/messages`)
                .then(response => response.json())
                .then(messages => {
                    messages.forEach(message => {
                        appendMessage({
                            content: message.content,
                            user: message.user,
                            created_at: new Date(message.created_at).toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' })
                        });
                    });
                });

            // Отправка сообщения
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const content = this.content.value.trim();
                
                if (!content) return;

                fetch(`/bookings/${bookingId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ content })
                })
                .then(response => response.json())
                .then(message => {
                    appendMessage({
                        content: message.content,
                        user: message.user,
                        created_at: new Date(message.created_at).toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' })
                    });
                    this.content.value = '';
                });
            });

            function appendMessage(message) {
                const isCurrentUser = message.user.id === {{ auth()->id() }};
                const messageHtml = `
                    <div class="mb-4 ${isCurrentUser ? 'text-right' : ''}">
                        <div class="inline-block max-w-[70%] ${isCurrentUser ? 'bg-blue-600' : 'bg-gray-700'} rounded-lg px-4 py-2">
                            ${!isCurrentUser ? `<div class="text-sm text-gray-300">${message.user.name}</div>` : ''}
                            <div class="text-white">${message.content}</div>
                            <div class="text-xs text-gray-400 mt-1">${message.created_at}</div>
                        </div>
                    </div>
                `;
                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
    @endpush
</x-app-layout> 
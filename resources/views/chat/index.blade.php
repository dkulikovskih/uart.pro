<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Заголовок чата -->
                    <div class="flex items-center mb-6">
                        <a href="{{ route('musicians.show', $user) }}" class="flex items-center text-white hover:text-blue-400 transition duration-300">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-400">{{ $user->instrument }}</p>
                            </div>
                        </a>
                    </div>

                    <!-- Сообщения -->
                    <div class="space-y-4 mb-6 max-h-[500px] overflow-y-auto" id="messages">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] {{ $message->user_id === auth()->id() ? 'bg-blue-600' : 'bg-gray-700' }} rounded-lg px-4 py-2">
                                    <p class="text-white">{{ $message->content }}</p>
                                    <p class="text-xs text-gray-300 mt-1">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Форма отправки сообщения -->
                    <form action="{{ route('chat.store', $user) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <div class="flex-1">
                            <input type="text" name="content" class="w-full rounded-lg bg-gray-700 border-gray-600 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Введите сообщение...">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Прокрутка к последнему сообщению
        const messagesContainer = document.getElementById('messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Автоматическое обновление сообщений каждые 5 секунд
        setInterval(() => {
            fetch(`{{ route('chat.index', $user) }}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMessages = doc.getElementById('messages');
                    messagesContainer.innerHTML = newMessages.innerHTML;
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        }, 5000);
    </script>
    @endpush
</x-app-layout> 
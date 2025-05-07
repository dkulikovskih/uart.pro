@props(['notifications'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($notifications->where('read', false)->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                {{ $notifications->where('read', false)->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Уведомления</h3>
        </div>
        
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <a href="{{ $notification->getLink() }}" 
                   class="block p-4 hover:bg-gray-50 border-b last:border-b-0 {{ $notification->read ? 'bg-white' : 'bg-blue-50' }}">
                    <div class="flex items-start space-x-3">
                        @if($notification->type === 'new_message')
                            <img src="{{ $notification->user->avatar_url }}" 
                                 alt="{{ $notification->user->name }}" 
                                 class="w-10 h-10 rounded-full">
                        @else
                            <div class="flex-shrink-0">
                                @if($notification->type === 'booking_confirmed')
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($notification->type === 'booking_cancelled')
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $notification->message }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-gray-500">
                    Нет новых уведомлений
                </div>
            @endforelse
        </div>

        @if($notifications->isNotEmpty())
            <div class="p-4 border-t">
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-sm text-blue-600 hover:text-blue-800">
                        Отметить все как прочитанные
                    </button>
                </form>
            </div>
        @endif
    </div>
</div> 
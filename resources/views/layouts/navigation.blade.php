<nav class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Главная') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                        {{ __('Заказы') }}
                    </x-nav-link>
                    <x-nav-link :href="route('musicians.index')" :active="request()->routeIs('musicians.*')">
                        {{ __('Музыканты') }}
                    </x-nav-link>
                </div>
            </div>

            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Кнопка уведомлений -->
                    <div class="ml-3 relative">
                        <button onclick="toggleNotifications()" class="relative inline-flex items-center p-2 text-sm font-medium text-white hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications()->count() }}
                                </span>
                            @endif
                        </button>

                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-gray-800 border border-gray-700">
                            <div class="p-4">
                                <div class="text-sm text-gray-300 mb-2 font-semibold">
                                    Уведомления
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                        <a href="{{ $notification->getLink() }}" class="block">
                                            <div class="p-3 {{ $notification->getBackgroundClass() }} rounded-lg mb-2 hover:bg-opacity-80 transition-colors duration-200">
                                                <div class="text-sm text-gray-200">
                                                    {{ $notification->message }}
                                                </div>
                                                <div class="text-xs text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                                @if(!$notification->read)
                                                    <form method="POST" action="{{ route('notifications.markAsRead', ['notification' => $notification->id]) }}" class="mt-2" onclick="event.stopPropagation()">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-blue-400 hover:text-blue-300">
                                                            Отметить как прочитанное
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </a>
                                    @empty
                                        <div class="text-sm text-gray-400 text-center py-4">
                                            Нет уведомлений
                                        </div>
                                    @endforelse
                                </div>
                                @if(auth()->user()->notifications()->count() > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-700">
                                        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-sm text-blue-400 hover:text-blue-300 text-center">
                                                Отметить все как прочитанные
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <button onclick="toggleProfile()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-gray-800 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-800 border border-gray-700">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                                    {{ __('Профиль') }}
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                                        {{ __('Выйти') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white">Войти</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-300 hover:text-white">Регистрация</a>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Главная') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                {{ __('Заказы') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('musicians.index')" :active="request()->routeIs('musicians.*')">
                {{ __('Музыканты') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Профиль') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Выйти') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
function toggleNotifications() {
    const dropdown = document.getElementById('notifications-dropdown');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (profileDropdown) {
        profileDropdown.classList.add('hidden');
    }
    
    dropdown.classList.toggle('hidden');
}

function toggleProfile() {
    const dropdown = document.getElementById('profile-dropdown');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    
    if (notificationsDropdown) {
        notificationsDropdown.classList.add('hidden');
    }
    
    dropdown.classList.toggle('hidden');
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

// Закрываем выпадающие меню при клике вне их области
document.addEventListener('click', function(event) {
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (notificationsDropdown && !notificationsDropdown.contains(event.target) && 
        !event.target.closest('button[onclick="toggleNotifications()"]')) {
        notificationsDropdown.classList.add('hidden');
    }
    
    if (profileDropdown && !profileDropdown.contains(event.target) && 
        !event.target.closest('button[onclick="toggleProfile()"]')) {
        profileDropdown.classList.add('hidden');
    }
});
</script>

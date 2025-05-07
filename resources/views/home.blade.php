<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Заголовок -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold mb-4 text-white">Добро пожаловать в Uart</h1>
            <p class="text-xl text-gray-300">Платформа для поиска и бронирования музыкантов</p>
        </div>

        <!-- Основные преимущества -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="text-blue-500 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Профессиональные музыканты</h3>
                <p class="text-gray-300">Найдите талантливых музыкантов с проверенным опытом и профессиональным образованием</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="text-blue-500 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Удобное бронирование</h3>
                <p class="text-gray-300">Планируйте выступления заранее с помощью удобного календаря и системы уведомлений</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="text-blue-500 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Безопасность</h3>
                <p class="text-gray-300">Гарантированная оплата и безопасное взаимодействие между музыкантами и заказчиками</p>
            </div>
        </div>

        <!-- Как это работает -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-white text-center mb-8">Как это работает</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-500">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Выберите музыканта</h3>
                    <p class="text-gray-300">Просмотрите профили и выберите подходящего исполнителя</p>
                </div>
                <div class="text-center">
                    <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-500">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Забронируйте дату</h3>
                    <p class="text-gray-300">Выберите удобное время и место выступления</p>
                </div>
                <div class="text-center">
                    <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-500">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Подтвердите заказ</h3>
                    <p class="text-gray-300">Согласуйте детали и подтвердите бронирование</p>
                </div>
                <div class="text-center">
                    <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-500">4</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Наслаждайтесь музыкой</h3>
                    <p class="text-gray-300">Получите незабываемые впечатления от живого выступления</p>
                </div>
            </div>
        </div>

        <!-- Призыв к действию -->
        <div class="text-center">
            @auth
                @if(auth()->user()->isMusician())
                    <a href="{{ route('bookings.calendar') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">Перейти к календарю</a>
                @else
                    <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">Мои заказы</a>
                @endif
            @else
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">Войти</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">Регистрация</a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout> 
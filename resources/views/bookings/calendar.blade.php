<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Календарь выступлений') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для управления выступлением -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modalTitle"></h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400" id="modalTime"></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400" id="modalStatus"></p>
                </div>
                <div class="items-center px-4 py-3">
                    <div id="modalActions" class="flex justify-center space-x-4">
                        <!-- Кнопки действий будут добавлены динамически -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <style>
        .fc-event {
            cursor: pointer;
            padding: 2px 4px;
        }
        .fc-event.pending {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        .fc-event.confirmed {
            background-color: #10b981;
            border-color: #10b981;
        }
        .fc-event.cancelled {
            background-color: #ef4444;
            border-color: #ef4444;
        }
        .fc-toolbar-title {
            color: #fff !important;
        }
        .fc-button {
            background-color: #4b5563 !important;
            border-color: #4b5563 !important;
        }
        .fc-button:hover {
            background-color: #374151 !important;
            border-color: #374151 !important;
        }
        .fc-button-active {
            background-color: #1f2937 !important;
            border-color: #1f2937 !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ru',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    @forelse($bookings as $booking)
                    {
                        id: '{{ $booking->id }}',
                        title: 'Выступление: {{ $booking->user->name }}',
                        start: '{{ $booking->start_time }}',
                        end: '{{ $booking->end_time }}',
                        className: '{{ $booking->status }}',
                        extendedProps: {
                            status: '{{ $booking->status }}',
                            description: '{{ $booking->description }}',
                            user: '{{ $booking->user->name }}',
                            url: '{{ route('bookings.show', $booking) }}'
                        }
                    },
                    @empty
                    // Нет бронирований
                    @endforelse
                ],
                eventClick: function(info) {
                    const modal = document.getElementById('eventModal');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalTime = document.getElementById('modalTime');
                    const modalStatus = document.getElementById('modalStatus');
                    const modalActions = document.getElementById('modalActions');

                    modalTitle.textContent = info.event.title;
                    modalTime.textContent = `Время: ${info.event.start.toLocaleString()} - ${info.event.end.toLocaleString()}`;
                    
                    let statusText = '';
                    switch(info.event.extendedProps.status) {
                        case 'pending':
                            statusText = 'Статус: Ожидает подтверждения';
                            break;
                        case 'confirmed':
                            statusText = 'Статус: Подтверждено';
                            break;
                        case 'cancelled':
                            statusText = 'Статус: Отменено';
                            break;
                    }
                    modalStatus.textContent = statusText;

                    // Очищаем предыдущие кнопки
                    modalActions.innerHTML = '';

                    // Добавляем кнопки в зависимости от статуса
                    if (info.event.extendedProps.status === 'pending') {
                        modalActions.innerHTML = `
                            <button onclick="confirmBooking(${info.event.id})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Подтвердить
                            </button>
                            <button onclick="cancelBooking(${info.event.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Отменить
                            </button>
                        `;
                    }

                    modal.classList.remove('hidden');
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        document.getElementById('calendar').innerHTML = '<div class="text-center p-4">Загрузка календаря...</div>';
                    }
                },
                eventDidMount: function(info) {
                    // Добавляем всплывающую подсказку
                    info.el.title = `${info.event.title}\n${info.event.extendedProps.description || ''}`;
                }
            });
            calendar.render();

            // Закрытие модального окна при клике вне его
            window.onclick = function(event) {
                const modal = document.getElementById('eventModal');
                if (event.target == modal) {
                    modal.classList.add('hidden');
                }
            }
        });

        function confirmBooking(id) {
            if (!confirm('Вы уверены, что хотите подтвердить это бронирование?')) {
                return;
            }
            
            fetch(`/bookings/${id}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Произошла ошибка при подтверждении бронирования');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при подтверждении бронирования');
            });
        }

        function cancelBooking(id) {
            if (!confirm('Вы уверены, что хотите отменить это бронирование?')) {
                return;
            }
            
            fetch(`/bookings/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Произошла ошибка при отмене бронирования');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при отмене бронирования');
            });
        }
    </script>
    @endpush
</x-app-layout> 
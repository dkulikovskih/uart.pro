import './bootstrap';

// Регистрация сервис-воркера для push-уведомлений
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
            console.log('ServiceWorker registration successful');
            
            // Инициализация Pusher Beams
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: '9e035686-477a-4d1c-bce8-78c3206216bb',
            });

            // Проверяем, авторизован ли пользователь
            const userId = document.querySelector('meta[name="user-id"]')?.content;
            
            if (userId) {
                // Если пользователь авторизован, привязываем устройство к его ID
                beamsClient.start()
                    .then(() => beamsClient.setUserId(userId))
                    .then(() => beamsClient.addDeviceInterest('user-' + userId))
                    .then(() => console.log('Successfully registered and subscribed to user channel!'))
                    .catch(console.error);
            } else {
                // Если пользователь не авторизован, подписываемся только на общие уведомления
                beamsClient.start()
                    .then(() => beamsClient.addDeviceInterest('hello'))
                    .then(() => console.log('Successfully registered and subscribed to public channel!'))
                    .catch(console.error);
            }
        }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

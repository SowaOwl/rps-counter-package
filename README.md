Пакет RPS Counter
-
Пакет для Laravel, предназначенный для подсчёта запросов в секунду (RPS) и логирования деталей запросов в базу данных. Пакет использует Redis для включения/выключения функциональности подсчёта и сохраняет данные о запросах (URL, IP-адрес, метод, время ответа и код состояния) в таблицу базы данных.

### Возможности:

Middleware для отслеживания деталей запросов и времени ответа.  
Сохранение данных запросов в таблицу rps_counts.  
Использование Redis для включения/выключения подсчёта запросов.  
Совместимость с Laravel 8.x, 9.x, 10.x и 11.x.  
Включает миграции и конфигурацию для простой настройки.

Требования:

- PHP 7.3 или 8.0+  
- Laravel 8.x, 9.x, 10.x или 11.x  
- Настроенный сервер Redis в вашем приложении Laravel  

### Установка:

Установите пакет через Composer:  
`composer require amanat/rps-counter`

Опубликуйте конфигурацию и миграции:  
`php artisan vendor:publish --tag=rps-counter-config`  
`php artisan vendor:publish --tag=rps-counter-migrations`  


Выполните миграции:  
`php artisan migrate`


Зарегистрируйте middleware:  
Добавьте middleware в ваш файл app/Http/Kernel.php в нужную группу middleware (например, web или api):  
`protected $middlewareGroups = [
'web' => [
\Amanat\RpsCounter\Http\Middleware\RpsCounterMiddleware::class,
],
];`

### Настройка:  
Пакет предоставляет файл конфигурации config/rps-counter.php, где проставляется ключ для переключения redis:
`return [
'redis_key' => env('RPS_COUNTER_REDIS_KEY', 'settings:rps_count'),
];`

### Использование:  
После настройки middleware будет:

Данные которые будут логироватся в таблицу rps_counts.

- URL
- IP-адрес
- HTTP-метод
- время ответа (в миллисекундах)
- код состояния каждого запроса

А так же включатся или выключатся в зависимости от значения ключа в redis.

### Схема базы данных:
Таблица rps_counts, создаваемая миграцией, содержит следующие столбцы:

- id: Первичный ключ
- url: URL запроса
- ip: IP-адрес клиента
- type: HTTP-метод (например, GET, POST)
- speed: Время ответа в миллисекундах
- status_code: Код состояния HTTP-ответа
- created_at, updated_at: Временные метки

Лицензия
MIT

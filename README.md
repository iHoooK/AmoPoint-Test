# AmoPoint Test

Тестовое задание на вакансию PHP-разработчика.

Проект реализован на Laravel 13 и закрывает:

1. Консольную команду с периодическим сбором данных из внешнего API.
2. JavaScript-логику динамического отображения полей по выбранному типу.
3. Дополнительное задание со счётчиком посещений, consent flow, ограничением доменов, авторизацией и dashboard со статистикой.

## Стек

- PHP 8.3
- Laravel 13
- SQLite
- Chart.js
- чистый JavaScript без сторонних библиотек для задач 2 и 3

## Задание 1

### Что сделано

- команда `php artisan jokes:fetch-random`
- scheduler каждые 5 минут
- сохранение данных из `https://official-joke-api.appspot.com/random_joke`
- JSON route `GET /api/jokes`
- HTML-страница `GET /jokes` с таблицей, пагинацией и сортировкой

### Сохраняемые поля

- `id`
- `external_id`
- `type`
- `setup`
- `punchline`
- `created_at`
- `updated_at`

### Проверка

```bash
php artisan jokes:fetch-random
php artisan schedule:list
php artisan test
```

Проверить в браузере:

- `http://127.0.0.1:8000/api/jokes`
- `http://127.0.0.1:8000/jokes`

## Задание 2

### Что сделано

Реализован JavaScript-код, который показывает только те поля, в чьём `name` содержится выбранное значение `Тип`.

Подготовлены два варианта использования:

- подключаемый файл: [public/js/testlist-fields.js](/C:/Users/Hoook/Desktop/AmoPoint-Test/public/js/testlist-fields.js)
- демонстрационная страница со встроенным кодом и сниппетом: `GET /test-task-2`

### Алгоритм

1. Находит `select[name="type_val"]`.
2. Собирает все элементы с атрибутом `name`, кроме самого селекта.
3. Для каждого элемента определяет контейнер `<p>`, чтобы скрывать строку целиком.
4. Скрывает пустые служебные блоки вида `<p>&nbsp;</p>`.
5. Проверяет условие `element.name.includes(selectedType)`.
6. Показывает только подходящие поля, остальные скрывает и отключает.

### Почему выбран такой подход

- логика соответствует формулировке задания буквально
- решение не привязано к жёстко захардкоженной карте полей
- новые поля с подходящим `name` будут обрабатываться автоматически
- интерфейс остаётся аккуратным, потому что скрывается весь визуальный блок

### Проверка

Открыть:

- `http://127.0.0.1:8000/test-task-2`

На странице доступны:

- локальная копия HTML-примера
- кнопка скачивания JS-файла
- раскрывающийся блок со сниппетом для запуска в консоли браузера на оригинальной странице

## Задание 3

### Что сделано

Реализован счётчик посещений страницы из двух частей:

- внешний JS-трекер, который можно подключить к сайту
- backend на Laravel, который принимает, хранит и визуализирует статистику

### Какие данные собираются

С клиента:

- `client_id`
- `page_url`
- `referrer`
- `device_type`
- `browser`
- `platform`
- `user_agent`
- `language`
- `screen_width`
- `screen_height`
- `timezone`

На сервере дополнительно определяются:

- `ip`
- `country`
- `city`
- `visited_at`

### Уникальность посещений

Для аналитики используется `client_id`, который генерируется в браузере и хранится в `localStorage`.

График по часам строится по количеству уникальных `client_id` в каждом часовом интервале.

### Безопасность и ограничения

Трекер принимает события только если одновременно выполняются условия:

- источник является локальной машиной или домен входит в whitelist из `.env`
- передан корректный `TRACKER_SITE_KEY`

Дополнительно реализован обязательный gate flow:

- пользователь не может попасть на отслеживаемую страницу без подтверждения согласия
- на consent-странице явно указано, что сбор данных выполняется в рамках тестового задания для AmoPoint

### Consent flow

Route:

- `GET /tracker/consent`

Отслеживаемая демо-страница:

- `GET /tracker/demo`

Логика:

1. Пользователь открывает `/tracker/demo`.
2. Без consent cookie происходит redirect на `/tracker/consent`.
3. Пользователь видит предупреждение о сборе данных.
4. Пока checkbox не отмечен, кнопка перехода недоступна.
5. После подтверждения выставляется cookie согласия и открывается демо-страница.
6. На демо-странице подключается трекер и отправляет событие визита.

### Трекер

Файл:

- [public/js/visit-tracker.js](/C:/Users/Hoook/Desktop/AmoPoint-Test/public/js/visit-tracker.js)

Пример подключения на внешний сайт:

```html
<script
    src="https://your-domain.example/js/visit-tracker.js"
    data-endpoint="https://your-domain.example/api/tracker/visits"
    data-site-key="amopoint-demo-key"
></script>
```

### Backend routes

- `POST /api/tracker/visits`
- `OPTIONS /api/tracker/visits`

### Админ-панель статистики

Login:

- `GET /login`

Dashboard:

- `GET /admin/statistics`

В dashboard реализовано:

- график уникальных посещений по часам
- круговая диаграмма по городам
- общее количество визитов
- количество уникальных клиентов
- время последнего визита

### Создание администратора

```bash
php artisan admin:create admin@example.com secret123 --name="Admin"
```

После этого можно войти в административную панель по указанным данным.

## Локальный запуск

1. Установить зависимости:

```bash
composer install
```

2. Создать `.env`:

```bash
copy .env.example .env
```

3. Сгенерировать ключ приложения:

```bash
php artisan key:generate
```

4. Убедиться, что существует файл `database/database.sqlite`.

5. Применить миграции:

```bash
php artisan migrate
```

6. Создать администратора:

```bash
php artisan admin:create admin@example.com secret123 --name="Admin"
```

7. Запустить приложение:

```bash
php artisan serve
```

## Настройки `.env` для трекера

```env
TRACKER_SITE_KEY=amopoint-demo-key
TRACKER_ALLOWED_DOMAINS=localhost,127.0.0.1
TRACKER_ALLOW_LOCAL_FILE=true
TRACKER_CONSENT_COOKIE=amopoint_tracking_consent
TRACKER_GEO_API_URL=https://ipwho.is
```

## Быстрая проверка выполнения тестового задания

### Задание 1

- открыть `/api/jokes`
- открыть `/jokes`

### Задание 2

- открыть `/test-task-2`
- проверить смену набора полей при изменении `Тип`
- скачать JS-файл или раскрыть встроенный сниппет

### Задание 3

1. Открыть:

- `/tracker/demo`

Подтвердить consent.

2. Обновить страницу несколько раз.

3. Войти в:

- `/login`

4. Открыть:

- `/admin/statistics`

## Тесты

```bash
php artisan test
```

Покрыты ключевые сценарии:

- команда сбора шуток
- JSON и HTML routes для задания 1
- demo и download для задания 2
- consent flow
- tracker API
- защита dashboard авторизацией
- доступ к dashboard после входа

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmoPoint Test</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.16), transparent 28%),
                radial-gradient(circle at right, rgba(255, 193, 7, 0.12), transparent 22%),
                linear-gradient(180deg, #f8fbff 0%, #eef2f8 100%);
            color: #111827;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 72px;
        }

        .hero {
            padding: 36px;
            border-radius: 30px;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 58%, #073b8a 100%);
            color: #fff;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.14);
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: 40px;
        }

        .hero p {
            margin: 0;
            max-width: 780px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.9);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 22px;
            margin-top: 28px;
        }

        .card {
            background: #fff;
            border-radius: 24px;
            padding: 26px;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.08);
        }

        .eyebrow {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 0 0 12px;
            font-size: 24px;
        }

        p {
            margin: 0 0 16px;
            color: #475569;
            line-height: 1.7;
        }

        ul {
            margin: 0 0 18px;
            padding-left: 20px;
            color: #334155;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .link.primary {
            background: #0d6efd;
            color: #fff;
        }

        .link.primary:hover {
            background: #0a58ca;
        }

        .link.secondary {
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
        }

        .link.secondary:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="page">
        <section class="hero">
            <h1>AmoPoint Test</h1>
            <p>Laravel-проект с тремя частями тестового задания: сбор данных из внешнего API по расписанию, JavaScript-логика динамического отображения полей и дополнительный модуль счётчика посещений с consent flow, авторизацией и визуализацией статистики.</p>
        </section>

        <section class="grid">
            <article class="card">
                <div class="eyebrow">Задание 1</div>
                <h2>Консольная команда и API</h2>
                <p>Команда каждые 5 минут получает случайную шутку из внешнего API, сохраняет её в БД, а проект отдает данные через JSON route и HTML-таблицу.</p>
                <ul>
                    <li>Scheduler: `jokes:fetch-random`</li>
                    <li>JSON route: `/api/jokes`</li>
                    <li>HTML-страница: `/jokes`</li>
                </ul>
                <div class="actions">
                    <a class="link primary" href="/jokes">Открыть таблицу</a>
                    <a class="link secondary" href="/api/jokes">Открыть JSON</a>
                </div>
            </article>

            <article class="card">
                <div class="eyebrow">Задание 2</div>
                <h2>Динамические поля на JavaScript</h2>
                <p>На локальной копии HTML-примера реализована логика, которая показывает только те поля, чьё значение `name` содержит выбранный тип. Там же доступны JS-файл и встроенный сниппет.</p>
                <ul>
                    <li>Чистый JavaScript без библиотек</li>
                    <li>Сниппет для запуска в консоли браузера</li>
                </ul>
                <div class="actions">
                    <a class="link primary" href="/test-task-2">Открыть демо</a>
                    <a class="link secondary" href="/test-task-2/download">Скачать JS</a>
                </div>
            </article>

            <article class="card">
                <div class="eyebrow">Задание 3</div>
                <h2>Счётчик посещений и статистика</h2>
                <p>Дополнительный модуль с gate-страницей согласия, внешним трекером, ограничением по доменам, административным входом и dashboard со статистикой по часам и городам.</p>
                <ul>
                    <li>Consent flow: `/tracker/consent`</li>
                    <li>Демо отслеживания: `/tracker/demo`</li>
                    <li>Статистика: `/admin/statistics`</li>
                </ul>
                <div class="actions">
                    <a class="link primary" href="/tracker/demo">Открыть демо</a>
                    <a class="link secondary" href="/admin/statistics">Войти в статистику</a>
                </div>
            </article>
        </section>
    </div>
</body>
</html>

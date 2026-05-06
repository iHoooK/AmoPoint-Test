<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Демо отслеживания</title>
    <style>
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; background: linear-gradient(180deg, #f8fbff 0%, #eef2f8 100%); color: #111827; }
        .page { max-width: 1040px; margin: 0 auto; padding: 48px 20px 64px; }
        .hero { padding: 36px; border-radius: 28px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 55%, #073b8a 100%); color: #fff; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14); }
        .hero h1 { margin: 0 0 16px; font-size: 36px; }
        .hero p { margin: 0; max-width: 760px; line-height: 1.7; color: rgba(255, 255, 255, 0.88); }
        .grid { display: grid; gap: 20px; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); margin-top: 24px; }
        .card { background: #fff; border-radius: 20px; padding: 24px; box-shadow: 0 20px 48px rgba(15, 23, 42, 0.08); }
        .eyebrow { color: #64748b; font-size: 14px; margin-bottom: 10px; }
        .muted { color: #475569; line-height: 1.7; }
    </style>
</head>
<body>
    <div class="page">
        <section class="hero">
            <h1>Демо-страница счётчика посещений</h1>
            <p>Эта страница используется для демонстрации дополнительного задания для AmoPoint. После подтверждения согласия загружается трекер, который отправляет на backend технические данные визита для построения статистики.</p>
        </section>
        <section class="grid">
            <article class="card">
                <div class="eyebrow">Сценарий</div>
                <h2>Что происходит</h2>
                <p class="muted">После прохождения gate-страницы браузер загружает внешний JS-трекер. Он генерирует `client_id`, определяет тип устройства, браузер, платформу, страницу и referrer, а сервер дополняет событие IP-адресом и городом.</p>
            </article>
            <article class="card">
                <div class="eyebrow">Безопасность</div>
                <h2>Ограничения</h2>
                <p class="muted">Трекинг принимает события только с локальной машины и с доменов, перечисленных в `TRACKER_ALLOWED_DOMAINS`. Дополнительно проверяется `TRACKER_SITE_KEY`.</p>
            </article>
            <article class="card">
                <div class="eyebrow">Проверка</div>
                <h2>Куда смотреть</h2>
                <p class="muted">После нескольких посещений откройте административную страницу статистики и убедитесь, что график по часам и диаграмма по городам обновились.</p>
            </article>
        </section>
    </div>
    <script>
        localStorage.setItem(@json(config('tracker.consent_cookie')), 'accepted');
    </script>
    <script
        src="{{ asset('js/visit-tracker.js') }}"
        data-endpoint="{{ route('tracker.visits') }}"
        data-site-key="{{ config('tracker.site_key') }}"
        data-require-consent="true"
        data-consent-key="{{ config('tracker.consent_cookie') }}"
    ></script>
</body>
</html>

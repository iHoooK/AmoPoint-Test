<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Согласие на обработку данных</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px; font-family: "Segoe UI", Arial, sans-serif; background: radial-gradient(circle at top, rgba(13, 110, 253, 0.14), transparent 26%), linear-gradient(180deg, #f8fbff 0%, #eef2f8 100%); color: #1f2937; }
        .card { width: min(760px, 100%); background: #fff; border-radius: 28px; box-shadow: 0 32px 80px rgba(15, 23, 42, 0.14); overflow: hidden; }
        .hero { padding: 32px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 55%, #073b8a 100%); color: #fff; }
        .hero h1 { margin: 0 0 12px; font-size: 30px; }
        .hero p { margin: 0; color: rgba(255, 255, 255, 0.88); line-height: 1.6; }
        .content { padding: 32px; }
        .content p, .content li { line-height: 1.7; }
        .content ul { margin: 0 0 20px; padding-left: 20px; }
        .notice { margin-bottom: 22px; padding: 18px 20px; border-radius: 16px; background: #f8fbff; border: 1px solid #dbe7f6; }
        .checkbox { display: flex; gap: 12px; align-items: flex-start; margin: 24px 0; font-weight: 600; }
        .checkbox input { margin-top: 4px; }
        .button { width: 100%; border: 0; border-radius: 16px; padding: 14px 18px; font: inherit; font-weight: 700; color: #fff; background: #0d6efd; cursor: pointer; }
        .button:disabled { cursor: not-allowed; background: #93c5fd; }
        .errors { margin: 0 0 16px; padding: 0; list-style: none; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="card">
        <div class="hero">
            <h1>Согласие на обработку данных</h1>
            <p>Доступ к странице открыт только после подтверждения согласия. Сбор данных выполняется в рамках тестового задания для AmoPoint.</p>
        </div>
        <div class="content">
            <div class="notice">
                <p><strong>Какие данные собираются:</strong> IP-адрес, город, страна, тип устройства, браузер, платформа, адрес страницы, источник перехода, язык браузера, разрешение экрана и время посещения.</p>
                <p><strong>Для чего:</strong> для демонстрации счётчика посещений, построения статистики по часам и диаграммы по городам в административной панели тестового задания.</p>
            </div>
            <ul>
                <li>Данные используются только в аналитических целях в рамках демонстрации решения.</li>
                <li>Без подтверждения согласия переход на отслеживаемую страницу невозможен.</li>
                <li>После подтверждения будет сохранён технический флаг согласия для доступа к странице.</li>
            </ul>
            @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="post" action="{{ route('tracker.consent.store') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirect }}">
                <label class="checkbox">
                    <input id="consent-checkbox" type="checkbox" name="accepted" value="1">
                    <span>Я ознакомился(ась) с условиями и соглашаюсь на обработку указанных технических данных в рамках тестового задания для AmoPoint.</span>
                </label>
                <button id="consent-submit" class="button" type="submit" disabled>Перейти на страницу</button>
            </form>
        </div>
    </div>
    <script>
        (function () {
            var checkbox = document.getElementById('consent-checkbox');
            var submitButton = document.getElementById('consent-submit');
            checkbox.addEventListener('change', function () {
                submitButton.disabled = !checkbox.checked;
            });
        }());
    </script>
</body>
</html>

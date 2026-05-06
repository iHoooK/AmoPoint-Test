<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 2</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.12), transparent 26%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f9 100%);
            color: #1f2937;
        }

        .page {
            max-width: 1080px;
            margin: 0 auto;
            padding: 40px 20px 64px;
        }

        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .hero {
            padding: 32px;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 55%, #073b8a 100%);
            color: #fff;
        }

        .hero h1 {
            margin: 0 0 12px;
            font-size: 32px;
        }

        .hero p {
            margin: 0;
            max-width: 720px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        .section {
            padding: 28px 32px;
            border-top: 1px solid #e5e7eb;
        }

        .demo-box {
            border: 1px solid #dbe7f6;
            border-radius: 18px;
            background: #f8fbff;
            padding: 24px;
        }

        .demo-box p {
            margin: 0 0 16px;
        }

        .demo-box p:last-child {
            margin-bottom: 0;
        }

        .demo-box input[type="text"],
        .demo-box select {
            min-width: 220px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font: inherit;
        }

        .demo-box input[type="button"] {
            padding: 10px 16px;
            border: 0;
            border-radius: 10px;
            background: #0d6efd;
            color: #fff;
            font: inherit;
            cursor: pointer;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .button-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .button-link.primary {
            background: #0d6efd;
            color: #fff;
        }

        .button-link.primary:hover {
            background: #0a58ca;
        }

        .button-link.secondary {
            border: 1px solid #cbd5e1;
            color: #334155;
            background: #fff;
        }

        .button-link.secondary:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        details {
            border: 1px solid #dbe7f6;
            border-radius: 18px;
            background: #fff;
            overflow: hidden;
        }

        summary {
            cursor: pointer;
            list-style: none;
            padding: 18px 22px;
            font-weight: 600;
            background: #f8fbff;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        .details-content {
            padding: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .details-content p,
        .details-content ol {
            line-height: 1.6;
        }

        .details-content ol {
            margin: 0 0 16px;
            padding-left: 20px;
        }

        .code-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .copy-button {
            border: 0;
            border-radius: 999px;
            padding: 10px 16px;
            background: #111827;
            color: #fff;
            font: inherit;
            cursor: pointer;
        }

        .copy-button:hover {
            background: #1f2937;
        }

        pre {
            margin: 0;
            padding: 18px;
            overflow-x: auto;
            border-radius: 16px;
            background: #0f172a;
            color: #e2e8f0;
            font-size: 14px;
            line-height: 1.55;
        }

        code {
            font-family: Consolas, "Courier New", monospace;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="hero">
                <h1>Задание 2. Динамическое отображение полей</h1>
                <p>Ниже размещена локальная копия HTML-примера из тестового задания с уже встроенной реализацией на чистом JavaScript. Логика показывает только те поля, чьё значение `name` содержит выбранный тип.</p>
            </div>

            <div class="section">
                <div class="demo-box">
                    <p>Тип &nbsp; &nbsp;<select name="type_val"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></p>

                    <p>Поле 1&nbsp; &nbsp;<input name="input_1" type="text"></p>

                    <p>&nbsp;</p>

                    <p>Поле 2&nbsp; &nbsp;<input name="input_2" type="text"></p>

                    <p>&nbsp;</p>

                    <p>Поле 3&nbsp; &nbsp;<input name="input_3" type="text"></p>

                    <p>Поле 4&nbsp; &nbsp;<input name="input_4" type="text"></p>

                    <p>Поле 5&nbsp; &nbsp;<input name="input_5" type="text"></p>

                    <p>Поле 6&nbsp; &nbsp;<input name="input_6" type="text"></p>

                    <p>Поле 7&nbsp; &nbsp;<input name="input_7" type="text"></p>

                    <p><input name="button_12" type="button" value="Кнопка 1"></p>

                    <p><input name="button_28" type="button" value="Кнопка 2"></p>

                    <p><input name="button_88" type="button" value="Кнопка 4"></p>

                    <p><input name="button_33" type="button" value="Кнопка 3"></p>

                    <p><input name="button_1" type="button" value="Кнопка 8"></p>
                </div>
            </div>

            <div class="section">
                <div class="actions">
                    <a class="button-link primary" href="{{ route('test-task-2.download') }}">Скачать JS-файл</a>
                    <a class="button-link secondary" href="http://test.amopoint-dev.ru/testzz/testlist.html" target="_blank" rel="noreferrer">Открыть оригинальную страницу</a>
                </div>
            </div>

            <div class="section">
                <details>
                    <summary>Посмотреть сниппет</summary>
                    <div class="details-content">
                        <p>Как использовать сниппет на оригинальной странице:</p>
                        <ol>
                            <li>Открыть `http://test.amopoint-dev.ru/testzz/testlist.html` в браузере.</li>
                            <li>Открыть DevTools.</li>
                            <li>Перейти на вкладку Console.</li>
                            <li>Вставить код ниже и выполнить.</li>
                        </ol>

                        <div class="code-toolbar">
                            <div class="muted">Сниппет можно запускать прямо в консоли браузера.</div>
                            <button class="copy-button" type="button" data-copy-snippet>Скопировать код</button>
                        </div>

                        <pre><code id="task-two-snippet">{{ $script }}</code></pre>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <script>
        {!! $script !!}
    </script>
    <script>
        (function () {
            var copyButton = document.querySelector('[data-copy-snippet]');
            var snippetElement = document.getElementById('task-two-snippet');

            if (!copyButton || !snippetElement) {
                return;
            }

            copyButton.addEventListener('click', function () {
                navigator.clipboard.writeText(snippetElement.textContent).then(function () {
                    copyButton.textContent = 'Скопировано';

                    window.setTimeout(function () {
                        copyButton.textContent = 'Скопировать код';
                    }, 1500);
                });
            });
        }());
    </script>
</body>
</html>

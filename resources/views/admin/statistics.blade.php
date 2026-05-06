<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика посещений</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(180deg, #f8fbff 0%, #eef2f8 100%);
            color: #111827;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 64px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .hero {
            flex: 1;
            padding: 32px;
            border-radius: 28px;
            color: #fff;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 55%, #073b8a 100%);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 34px;
        }

        .hero p {
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.6;
        }

        .stats-grid,
        .charts-grid {
            display: grid;
            gap: 20px;
            margin-top: 24px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .charts-grid {
            grid-template-columns: 2fr 1fr;
        }

        .card {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 20px 48px rgba(15, 23, 42, 0.08);
        }

        .metric {
            font-size: 34px;
            font-weight: 700;
            margin: 6px 0 0;
        }

        .eyebrow {
            color: #64748b;
            font-size: 14px;
        }

        .logout {
            border: 0;
            border-radius: 999px;
            padding: 12px 16px;
            background: #111827;
            color: #fff;
            font: inherit;
            cursor: pointer;
        }

        .chart-shell {
            position: relative;
            width: 100%;
        }

        .chart-shell.hourly {
            height: 520px;
            max-height: 520px;
        }

        .chart-shell.cities {
            height: 320px;
            max-height: 320px;
        }

        .chart-shell canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 100%;
        }

        .snippet-card {
            margin-top: 24px;
        }

        .snippet-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
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
            line-height: 1.6;
        }

        code {
            font-family: Consolas, "Courier New", monospace;
        }

        .muted {
            color: #64748b;
            line-height: 1.7;
        }

        @media (max-width: 900px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .chart-shell.hourly {
                height: 420px;
                max-height: 420px;
            }

            .snippet-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div class="hero">
                <h1>Статистика посещений</h1>
                <p>Административная панель дополнительного задания для AmoPoint. Горизонтальный график показывает количество уникальных посетителей по часам, круговая диаграмма — распределение по городам.</p>
            </div>

            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Выйти</button>
            </form>
        </div>

        <section class="stats-grid">
            <article class="card">
                <div class="eyebrow">Всего визитов</div>
                <div class="metric">{{ $totalVisits }}</div>
            </article>

            <article class="card">
                <div class="eyebrow">Уникальных клиентов</div>
                <div class="metric">{{ $uniqueClients }}</div>
            </article>

            <article class="card">
                <div class="eyebrow">Последний визит</div>
                <div class="metric" style="font-size: 22px;">{{ $latestVisit ? \Illuminate\Support\Carbon::parse($latestVisit)->format('d.m.Y H:i') : 'Нет данных' }}</div>
            </article>
        </section>

        <section class="charts-grid">
            <article class="card">
                <div class="eyebrow">Уникальные посещения по часам</div>
                <div class="chart-shell hourly">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </article>

            <article class="card">
                <div class="eyebrow">Города</div>
                <div class="chart-shell cities">
                    <canvas id="citiesChart"></canvas>
                </div>
            </article>
        </section>

        <section class="card snippet-card">
            <div class="eyebrow">Код для внешнего сайта</div>
            <h2 style="margin: 0 0 10px;">Подключение трекера</h2>
            <p class="muted">Этот код сформирован от текущего домена, на котором развернут проект. Его можно вставить на сторонний сайт, если домен разрешён в `TRACKER_ALLOWED_DOMAINS` и используется корректный `TRACKER_SITE_KEY`.</p>

            <div class="snippet-toolbar">
                <div class="muted">Если проект будет развернут на другом домене, код на этой странице автоматически перестроится под новый адрес.</div>
                <button class="copy-button" type="button" data-copy-tracker>Скопировать код</button>
            </div>

            <pre><code id="tracker-snippet">{{ $trackerSnippet }}</code></pre>
        </section>
    </div>

    <script>
        new Chart(document.getElementById('hourlyChart'), {
            type: 'bar',
            data: {
                labels: @json($hourlyLabels),
                datasets: [{
                    label: 'Уникальные посещения',
                    data: @json($hourlyStats),
                    backgroundColor: 'rgba(13, 110, 253, 0.82)',
                    borderRadius: 12,
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });

        new Chart(document.getElementById('citiesChart'), {
            type: 'pie',
            data: {
                labels: @json($cityLabels),
                datasets: [{
                    data: @json($cityStats),
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14', '#20c997', '#6610f2', '#0dcaf0', '#adb5bd'],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });

        (function () {
            var copyButton = document.querySelector('[data-copy-tracker]');
            var snippetElement = document.getElementById('tracker-snippet');

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

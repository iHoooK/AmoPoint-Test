<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jokes</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(255, 193, 7, 0.12), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f9 100%);
        }

        .page-shell {
            padding: 48px 0 64px;
        }

        .hero-card {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(31, 41, 55, 0.12);
            overflow: hidden;
        }

        .hero-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 52%, #073b8a 100%);
            color: #fff;
            margin-bottom: 20px;
        }

        .table thead th {
            white-space: nowrap;
            background: #f8fafc;
            color: #495057;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .table tbody td {
            vertical-align: top;
        }

        .sort-link {
            color: inherit;
            text-decoration: none;
        }

        .sort-link:hover {
            color: #0d6efd;
        }

        .setup-cell,
        .punchline-cell {
            min-width: 260px;
        }

        .pagination-wrapper {
            .small.text-muted {
                display: none;
            }
        }
    </style>
</head>
<body>
    @php
        $sortLabels = [
            'id' => 'ID',
            'external_id' => 'External ID',
            'type' => 'Type',
        ];

        $nextDirection = static function (string $column) use ($sort, $direction): string {
            if ($sort !== $column) {
                return 'asc';
            }

            return $direction === 'asc' ? 'desc' : 'asc';
        };

        $sortIndicator = static function (string $column) use ($sort, $direction): string {
            if ($sort !== $column) {
                return '';
            }

            return $direction === 'asc' ? '↑' : '↓';
        };
    @endphp

    <div class="container page-shell">
        <div class="card hero-card">
            <div class="hero-header p-4 p-lg-5">
                <h1 class="display-6 fw-semibold mb-0">Сохранённые шутки</h1>
            </div>

            @if ($jokes->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <a class="sort-link" href="{{ route('jokes.table', ['sort' => 'id', 'direction' => $nextDirection('id')]) }}">
                                        ID {{ $sortIndicator('id') }}
                                    </a>
                                </th>
                                <th>
                                    <a class="sort-link" href="{{ route('jokes.table', ['sort' => 'external_id', 'direction' => $nextDirection('external_id')]) }}">
                                        External ID {{ $sortIndicator('external_id') }}
                                    </a>
                                </th>
                                <th>
                                    <a class="sort-link" href="{{ route('jokes.table', ['sort' => 'type', 'direction' => $nextDirection('type')]) }}">
                                        Type {{ $sortIndicator('type') }}
                                    </a>
                                </th>
                                <th>Setup</th>
                                <th>Punchline</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jokes as $joke)
                                <tr>
                                    <td class="fw-semibold">{{ $joke->id }}</td>
                                    <td>{{ $joke->external_id }}</td>
                                    <td>
                                        <span class="badge text-bg-light border">{{ $joke->type }}</span>
                                    </td>
                                    <td class="setup-cell">{{ $joke->setup }}</td>
                                    <td class="punchline-cell">{{ $joke->punchline }}</td>
                                    <td class="text-nowrap text-secondary">{{ $joke->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-4 bg-body-tertiary border-top pagination-wrapper">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                        <div class="pagination-summary">
                            Показано {{ $jokes->firstItem() }}-{{ $jokes->lastItem() }} из {{ $jokes->total() }}
                        </div>
                        {{ $jokes->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="p-5 text-center">
                    <h2 class="h4 mb-3">Шуток пока нет</h2>
                    <p class="text-secondary mb-0">Запустите `php artisan jokes:fetch-random`, чтобы наполнить таблицу данными.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

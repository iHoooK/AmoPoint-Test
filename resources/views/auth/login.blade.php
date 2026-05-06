<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в статистику</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px; font-family: "Segoe UI", Arial, sans-serif; background: linear-gradient(180deg, #f8fbff 0%, #eef2f8 100%); }
        .card { width: min(420px, 100%); background: #fff; border-radius: 24px; padding: 32px; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12); }
        h1 { margin: 0 0 10px; }
        p { color: #64748b; line-height: 1.6; }
        label { display: block; margin: 16px 0 8px; font-weight: 600; }
        input[type="email"], input[type="password"] { width: 100%; box-sizing: border-box; padding: 12px 14px; border-radius: 14px; border: 1px solid #cbd5e1; font: inherit; }
        .checkbox { display: flex; gap: 10px; margin: 16px 0 20px; color: #475569; }
        button { width: 100%; border: 0; border-radius: 14px; padding: 14px 18px; background: #0d6efd; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
        .errors { margin: 0; padding-left: 18px; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Статистика посещений</h1>
        <p>Вход в административную панель тестового задания для AmoPoint.</p>
        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="post" action="{{ route('login.store') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>
            <label class="checkbox">
                <input name="remember" type="checkbox" value="1">
                <span>Запомнить меня</span>
            </label>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>

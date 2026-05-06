<?php

use App\Console\Commands\CreateAdminUserCommand;
use App\Console\Commands\FetchRandomJokeCommand;
use App\Http\Middleware\EnsureTrackingConsent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        CreateAdminUserCommand::class,
        FetchRandomJokeCommand::class,
    ])
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('jokes:fetch-random')->everyFiveMinutes();
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tracking.consent' => EnsureTrackingConsent::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

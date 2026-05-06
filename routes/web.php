<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JokeController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TestTaskController;
use App\Http\Controllers\TrackerConsentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/jokes', [JokeController::class, 'table'])->name('jokes.table');
Route::get('/test-task-2', [TestTaskController::class, 'taskTwo'])->name('test-task-2');
Route::get('/test-task-2/download', [TestTaskController::class, 'downloadTaskTwoScript'])->name('test-task-2.download');
Route::get('/tracker/consent', [TrackerConsentController::class, 'show'])->name('tracker.consent');
Route::post('/tracker/consent', [TrackerConsentController::class, 'store'])->name('tracker.consent.store');
Route::view('/tracker/demo', 'tracker.demo')->middleware('tracking.consent')->name('tracker.demo');

Route::middleware('auth')->group(function () {
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
});

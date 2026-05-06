<?php

use App\Http\Controllers\JokeController;
use App\Http\Controllers\TestTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jokes', [JokeController::class, 'table'])->name('jokes.table');
Route::get('/test-task-2', [TestTaskController::class, 'taskTwo'])->name('test-task-2');
Route::get('/test-task-2/download', [TestTaskController::class, 'downloadTaskTwoScript'])->name('test-task-2.download');

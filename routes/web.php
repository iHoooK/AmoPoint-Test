<?php

use App\Http\Controllers\JokeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jokes', [JokeController::class, 'table'])->name('jokes.table');

<?php

use App\Http\Controllers\JokeController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/jokes', [JokeController::class, 'index']);
Route::options('/tracker/visits', [TrackerController::class, 'options'])->name('tracker.visits.options');
Route::post('/tracker/visits', [TrackerController::class, 'store'])->name('tracker.visits');

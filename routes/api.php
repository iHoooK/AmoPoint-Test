<?php

use App\Http\Controllers\JokeController;
use Illuminate\Support\Facades\Route;

Route::get('/jokes', [JokeController::class, 'index']);

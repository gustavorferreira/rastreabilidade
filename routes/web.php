<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MetricsController;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/health', HealthCheckResultsController::class); 
Route::get('/metrics', [MetricsController::class, 'index']);
Route::get('/login', [HomeController::class, 'login'])->name('login');

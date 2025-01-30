<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\Auth\AuthenticatorController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthenticatorController::class, 'authenticate'])->name('login');
    Route::post('/register', [AuthenticatorController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/currentUser', [AuthenticatorController::class, 'currentUser']);
    Route::post('/auth/logout', [AuthenticatorController::class, 'logout']);
});

Route::get('/countries', action: [CountriesController::class, 'index']);

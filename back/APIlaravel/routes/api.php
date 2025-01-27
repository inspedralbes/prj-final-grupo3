<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\Auth\AuthenticatorController;

Route::prefix('auth')->group(function () {
    Route::post('/logout', [AuthenticatorController::class, 'logout']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::post('/register', [AuthenticatorController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthenticatorController::class, 'currentUser']);
});

Route::get('/countries', [CountriesController::class, 'index']);
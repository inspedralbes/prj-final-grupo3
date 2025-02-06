<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesApiController;
use App\Http\Controllers\Auth\AuthenticatorController;
use App\Http\Controllers\UserApiController;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthenticatorController::class, 'authenticate'])->name('login');
    Route::post('/register', [AuthenticatorController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/currentUser', [AuthenticatorController::class, 'currentUser']);
    Route::post('/auth/logout', [AuthenticatorController::class, 'logout']);
    Route::put('/changeInfoProfile', [UserApiController::class, 'update']);
});



Route::get('/countries', action: [CountriesApiController::class, 'index']);

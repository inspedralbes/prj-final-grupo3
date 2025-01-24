<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\Auth\AuthenticatorController;


Route::post('/register', [AuthenticatorController::class, 'register']);
Route::post('/login', [AuthenticatorController::class, 'authenticate']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatorController::class, 'logout']);
    Route::get('/user', [AuthenticatorController::class, 'currentUser']);
});

Route::get('/countries', [CountriesController::class, 'index']);
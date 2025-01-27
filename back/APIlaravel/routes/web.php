<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

// Esta ruta debería estar definida automáticamente por Sanctum, pero asegúrate de que esté en tu archivo routes/web.php
// Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');

Route::get('/', function () {
    return view('welcome');
});


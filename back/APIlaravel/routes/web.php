<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\TravelsController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('admin.login');
})->name('login');

Route::get('/home', function () {
    return view('layout.index');
})->name('home');

Route::post('/', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/usuaris', [UsersController::class, 'index'])->name('users');
    Route::get('/usuaris/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::post('/usuaris', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/usuaris/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    // Mostrar el formulario de edición de usuari
    Route::get('/usuaris/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');

    // Actualizar un usuari
    Route::put('/usuaris/{id}', [UsersController::class, 'update'])->name('users.update');


    Route::get('/countries', [CountriesController::class, 'index'])->name('countries');
    Route::post('/countries', [CountriesController::class, 'store'])->name('countries.store');
    Route::delete('/countries/{id}', [CountriesController::class, 'destroy'])->name('countries.destroy');
    // Mostrar el formulario de edición de país
    Route::get('/countries/{id}/edit', [CountriesController::class, 'edit'])->name('countries.edit');

    // Actualizar un país
    Route::put('/countries/{id}', [CountriesController::class, 'update'])->name('countries.update');

    // Route::get('/countries', [TravelsController::class, 'index'])->name('travels');
    // Route::get('/countries', [PublicationsController::class, 'index'])->name('publications');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

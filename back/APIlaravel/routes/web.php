<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\TravelsController;

Route::get('/', function () {
    return view('admin.login');
});

Route::get('/home', function () {
    return view('layout.index');
})->name('home');

Route::get('/usuaris', [UsersController::class, 'index'])->name('users');

Route::get('/countries', [CountriesController::class, 'index'])->name('countries');
Route::post('/countries', [CountriesController::class, 'store'])->name('countries.store');
Route::delete('/countries/{id}', [CountriesController::class, 'destroy'])->name('countries.destroy');
// Mostrar el formulario de edición de país
Route::get('/countries/{id}/edit', [CountriesController::class, 'edit'])->name('countries.edit');

// Actualizar un país
Route::put('/countries/{id}', [CountriesController::class, 'update'])->name('countries.update');

// Route::get('/countries', [TravelsController::class, 'index'])->name('travels');
// Route::get('/countries', [PublicationsController::class, 'index'])->name('publications');
// Proba canvi

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});

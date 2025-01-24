<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\TravelsController;

Route::get('/', function () {
    return view('layout.index');
})->name('home');

Route::get('/login', function () {
    return view('admin.login');
});

Route::get('/usuaris', [UsersController::class, 'index'])->name('users');
Route::get('/countries', [CountriesController::class, 'index'])->name('countries');
// Route::get('/countries', [TravelsController::class, 'index'])->name('travels');
// Route::get('/countries', [PublicationsController::class, 'index'])->name('publications');

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});

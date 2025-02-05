<?php

use App\Models\User;
use App\Models\Budget;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TravelsController;
use App\Http\Controllers\MovilityController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\TravelTypeController;
use App\Http\Controllers\PublicationsController;

// Ruta principal para el panel de administración
Route::get('/', function () {
    if (auth('admin')->check()) {
        return redirect()->route('users');
    }
    return view('admin.login');
})->name('login');

// Ruta para la comprovación de autenticación de l'admin
Route::post('/', [AuthController::class, 'login'])->name('login');

// Rutas protegidas por autenticación
Route::middleware(['auth:admin'])->group(function () {
    // Rutas para el panel de administración de usuarios
    Route::get('/usuaris', [UsersController::class, 'index'])->name('users');
    Route::get('/usuaris/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::post('/usuaris', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/usuaris/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('/usuaris/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/usuaris/{id}', [UsersController::class, 'update'])->name('users.update');

    // Rutas para el panel de administración de paises
    Route::get('/countries', [CountriesController::class, 'index'])->name('countries');
    Route::post('/countries', [CountriesController::class, 'store'])->name('countries.store');
    Route::delete('/countries/{id}', [CountriesController::class, 'destroy'])->name('countries.destroy');
    Route::get('/countries/{id}/edit', [CountriesController::class, 'edit'])->name('countries.edit');
    Route::put('/countries/{id}', [CountriesController::class, 'update'])->name('countries.update');

    // Rutas para el panel de administración de tipus de viaje
    Route::get('/travel-types', [TravelTypeController::class, 'index'])->name('travel-types');
    Route::post('/travel-types', [TravelTypeController::class, 'store'])->name('travel-types.store');

    // Rutas para el panel de administración de mobilitats
    Route::get('/movilities', [MovilityController::class, 'index'])->name('movilities');

    // Rutas para el panel de administración de presupuestos
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets');

    // Rutas para el panel de administración de viatges
    Route::get('/travels', [TravelsController::class, 'index'])->name('travels');
    Route::get('/travels/{id}', [TravelsController::class, 'show'])->name('travels.show');

    // Rutas para el panel de administración de publicaciones
    Route::get('/publications', [PublicationsController::class, 'index'])->name('publications');

    // Rutas para el panel de administración de logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

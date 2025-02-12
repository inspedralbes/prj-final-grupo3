<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesApiController;
use App\Http\Controllers\Auth\AuthenticatorController;
use App\Http\Controllers\SendMail;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\TravelsController;
use App\Http\Controllers\MovilityController;
use App\Http\Controllers\TravelTypeController;
 
Route::post('/sendEmail',[SendMail::class, 'sendEmail']);
 
Route::get('/view', function () {
    return view('email.blade.php', ['message' => 'Este es un mensaje dinámico']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthenticatorController::class, 'authenticate'])->name('login');
    Route::post('/register', [AuthenticatorController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/trip-details/{id}', [UserApiController::class, 'travelHistory']);
    Route::get('/currentUser', [AuthenticatorController::class, 'currentUser']);
    Route::post('/auth/logout', [AuthenticatorController::class, 'logout']);
    Route::put('/changeInfoProfile', [UserApiController::class, 'update']);
});


//get countries,movilities,types
Route::get('/countries', action: [CountriesApiController::class, 'index']);
Route::get('/movilities',action: [MovilityController::class, 'indexApi']);
Route::get('/types', action: [TravelTypeController::class, 'typesApi']);

// Route::post('/travels', [TravelsController::class, 'store']);
Route::post('/travels', [TravelsController::class, 'storetravel']);

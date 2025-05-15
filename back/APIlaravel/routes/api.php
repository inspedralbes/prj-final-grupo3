<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesApiController;
use App\Http\Controllers\Auth\AuthenticatorController;
use App\Http\Controllers\SendMail;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\TravelsController;
use App\Http\Controllers\TravelPlanController;
use App\Http\Controllers\MovilityController;
use App\Http\Controllers\TravelTypeController;
use App\Http\Controllers\TravelMailController;
use App\Http\Controllers\RecommendedTripController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CommentLikeController;
use App\Models\RecommendedTrip;


Route::post('/sendEmail', [SendMail::class, 'sendEmail']);

Route::get('/view', function () {
  return view('email.blade.php', ['message' => 'Este es un mensaje dinámico']);
});

Route::prefix('auth')->group(function () {
  Route::post('/login', [AuthenticatorController::class, 'authenticate'])->name('login');
  Route::post('/register', [AuthenticatorController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/trip-details/{id}', [UserApiController::class, 'travelHistory']);
  Route::delete('/trip-details/{userId}/{tripId}', [UserApiController::class, 'deleteTravel']);
  Route::post('/toggle-favorite', [UserApiController::class, 'toggleFavorite']);
  Route::get('/user-favorites', [UserApiController::class, 'getUserFavorites']);
  Route::get('/currentUser', [AuthenticatorController::class, 'currentUser']);
  Route::post('/auth/logout', [AuthenticatorController::class, 'logout']);
  Route::patch('/changeInfoProfile', [UserApiController::class, 'update']);
});


//get countries,movilities,types
Route::get('/countries', action: [CountriesApiController::class, 'index']);
Route::get('/movilities', action: [MovilityController::class, 'indexApi']);
Route::get('/types', action: [TravelTypeController::class, 'typesApi']);

Route::post('/travels', [TravelsController::class, 'storetravel']);

Route::post('/travel-plans', [TravelPlanController::class, 'storeTravelPlan']);

//Route::middleware('auth:sanctum')->post('/travel/{id}/send-email', [TravelMailController::class, 'send']);
// Route::middleware('auth:sanctum')->post('/travel/{id}/send-email', [TravelMailController::class, 'send']);
// routes/api.php
// Route::middleware('auth:sanctum')->post('/travel/{id}/send-email', [TravelMailController::class, 'send']);

Route::post('/travel/{id}/send-email', [TravelMailController::class, 'send']);

Route::get('/travel-plan/{id}', [TravelsController::class, 'getByTravelId']);

Route::get('/trips/highlighted', [RecommendedTripController::class, 'highlighted']);

Route::get('/trips/{id}', [RecommendedTripController::class, 'show']);

Route::get('/comments', [CommentController::class, 'index']);

Route::middleware('auth:sanctum')->post('/comments', [CommentController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/comments/{id}', [CommentController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('/comment-like', [CommentLikeController::class, 'store']);



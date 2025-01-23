<?php

use App\Http\Controllers\CountriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/countries', [CountriesController::class, 'index']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});
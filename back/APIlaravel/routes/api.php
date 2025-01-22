<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.index');
});

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});

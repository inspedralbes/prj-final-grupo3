<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.index');
});

Route::get('/login', function () {
    return view('layout.login');
});

Route::get('/usuaris', function () {
    return view('admin.usuaris');
});

Route::get('/message', function () {
    return response()->json([
        'message' => 'Aquest és el missatge que vols enviar en format JSON.'
    ]);
});

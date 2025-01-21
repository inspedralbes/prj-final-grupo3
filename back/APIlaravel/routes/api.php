<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/example', function () {
    return response()->json([
        'message' => 'Hello from the API'
    ]);
});
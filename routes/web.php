<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'v' => '1.0'
    ]);
});
<?php

use App\Http\Controllers\Rest\TicketController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1.0/tickets '], function () {
    Route::post('/', [TicketController::class, 'store']);
    Route::get('/', [TicketController::class, 'list']);
});

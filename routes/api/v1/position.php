<?php

use App\Http\Controllers\Api\V1\Positions\GetClosedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetOpenedPositionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'positions', 'as' => 'positions.'], function () {
    Route::get('/opened', GetOpenedPositionController::class)->name('opened.list');
    Route::get('/closed', GetClosedPositionController::class)->name('closed.list');
});



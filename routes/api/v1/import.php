<?php

use App\Http\Controllers\Api\V1\Import\ImportController;
use App\Http\Controllers\Api\V1\Import\StatusController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
    Route::post('/', ImportController::class);
    Route::get('/status', StatusController::class)->name('status');
});



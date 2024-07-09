<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => 'auth:sanctum', 'api'], function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

});

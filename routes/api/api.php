<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::group(['middleware' => 'api'], function () {
        require __DIR__ . '/auth.php';
    });

    Route::group(['middleware' => 'auth:sanctum', 'api'], function () {
        foreach (File::files(__DIR__ . '/v1') as $api) {
            require $api;
        }
    });
});

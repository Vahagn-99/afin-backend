<?php

use App\Http\Controllers\Bonus\ManagerBonusController;
use App\Http\Controllers\Bonus\ManagerCurrentMonthBonusController;
use App\Http\Controllers\Manager\ManagerControllerListController;
use App\Http\Controllers\Rating\ManagerAllTimesRatingController;
use App\Http\Controllers\Rating\ManagerMonthlyRatingController;
use App\Http\Controllers\Rating\ManagerRatingHistoriesController;
use App\Http\Controllers\Rating\ManagerYearlyRatingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'managers', 'as' => 'managers.'], function () {
    Route::get('/', ManagerControllerListController::class)->name('list');
    Route::group(['prefix' => 'ratings', 'as' => 'ratings.'], function () {
        Route::get('/all', ManagerAllTimesRatingController::class)->name('all-times');
        Route::get('/monthly/{month}', ManagerMonthlyRatingController::class)->name('monthly');
        Route::get('/yearly/{year}', ManagerYearlyRatingController::class)->name('yearly');
        Route::get('/histories', ManagerRatingHistoriesController::class)->name('histories.list');
    });
    Route::group(['prefix' => 'bonuses', 'as' => 'bonuses.'], function () {
        Route::get('/monthly', ManagerBonusController::class)->name('list');
        Route::get('/current', ManagerCurrentMonthBonusController::class)->name('list.current');
    });
});



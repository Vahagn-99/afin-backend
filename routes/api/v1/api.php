<?php

use App\Http\Controllers\Api\V1\History\GetHistoriesController;
use App\Http\Controllers\Api\V1\History\GetHistoryController;
use App\Http\Controllers\Api\V1\Import\ImportController;
use App\Http\Controllers\Api\V1\Import\StatusController;
use App\Http\Controllers\Api\V1\Positions\GetClosedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetOpenedPositionController;
use App\Http\Controllers\Api\V1\Transaction\CloseMonthController;
use App\Http\Controllers\Api\V1\Transaction\GetTransactionListController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['middleware' => 'auth:sanctum', 'api'], function () {
        Route::group(['prefix' => 'transactions', 'name' => 'transactions.'], function () {
            Route::post('/close', CloseMonthController::class)->name('close-month');
            Route::get('/', GetTransactionListController::class)->name('list');
            Route::get('/histories', GetHistoriesController::class)->name('histories.list');
            Route::get('/histories/{history}', GetHistoryController::class)->name('histories.month');
        });
        Route::group(['prefix' => 'positions', 'name' => 'positions.'], function () {
            Route::get('/opened', GetOpenedPositionController::class)->name('opened.list');
            Route::get('/closed', GetClosedPositionController::class)->name('closed.list');
        });
        Route::post('/import', ImportController::class)->name('import');
        Route::get('/import/status', StatusController::class)->name('import.status');
    });
});

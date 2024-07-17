<?php

use App\Http\Controllers\Api\V1\CloseMonth\CloseMonthController;
use App\Http\Controllers\Api\V1\Contact\GetContactController;
use App\Http\Controllers\Api\V1\Archive\GeArchivesController;
use App\Http\Controllers\Api\V1\Import\ImportController;
use App\Http\Controllers\Api\V1\Import\StatusController;
use App\Http\Controllers\Api\V1\Positions\GetArchivedClosedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetArchivedOpenedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetClosedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetOpenedPositionController;
use App\Http\Controllers\Api\V1\Transaction\GetArchivedTransactionsController;
use App\Http\Controllers\Api\V1\Transaction\GetTransactionListController;
use App\Http\Controllers\Bonus\ManagerBonusController;
use App\Http\Controllers\Bonus\ManagerCurrentMonthBonusController;
use App\Http\Controllers\Manager\ManagerControllerListController;
use App\Http\Controllers\Rating\ManagerAllTimesRatingController;
use App\Http\Controllers\Rating\ManagerMonthlyRatingController;
use App\Http\Controllers\Rating\ManagerRatingHistoriesController;
use App\Http\Controllers\Rating\ManagerYearlyRatingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['middleware' => 'auth:sanctum', 'api'], function () {
        Route::group(['prefix' => 'managers', 'name' => 'managers.'], function () {
            Route::get('/', ManagerControllerListController::class)->name('list');
            Route::group(['prefix' => 'ratings', 'name' => 'ratings.'], function () {
                Route::get('/all', ManagerAllTimesRatingController::class)->name('all-times');
                Route::get('/monthly/{month}', ManagerMonthlyRatingController::class)->name('monthly');
                Route::get('/yearly/{year}', ManagerYearlyRatingController::class)->name('yearly');
                Route::get('/histories', ManagerRatingHistoriesController::class)->name('histories.list');
            });
            Route::group(['prefix' => 'bonuses', 'name' => 'bonuses.'], function () {
                Route::get('/monthly', ManagerBonusController::class)->name('list');
                Route::get('/current', ManagerCurrentMonthBonusController::class)->name('list.current');
            });
        });

        Route::group(['prefix' => 'transactions', 'name' => 'transactions.'], function () {
            Route::get('/', GetTransactionListController::class)->name('list');
        });
        Route::group(['prefix' => 'positions', 'name' => 'positions.'], function () {
            Route::get('/opened', GetOpenedPositionController::class)->name('opened.list');
            Route::get('/closed', GetClosedPositionController::class)->name('closed.list');

        });

        Route::post('/close', CloseMonthController::class)->name('close-month');

        Route::group(['prefix' => 'archives', 'name' => 'archives.'], function () {
            Route::get('/', GeArchivesController::class)->name('list');
            Route::get('/{history}/positions/opened', GetArchivedOpenedPositionController::class)->name('opened.list');
            Route::get('/{history}/positions/closed', GetArchivedClosedPositionController::class)->name('closed.list');
            Route::get('/{history}/transactions', GetArchivedTransactionsController::class)->name('transactions.list');
        });

        Route::post('/import', ImportController::class)->name('import');
        Route::get('/import/status', StatusController::class)->name('import.status');
        Route::get('/contacts', GetContactController::class)->name('contacts.list');

    });
});

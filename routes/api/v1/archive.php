<?php

use App\Http\Controllers\Api\V1\Archive\GeArchivesController;
use App\Http\Controllers\Api\V1\Positions\GetArchivedClosedPositionController;
use App\Http\Controllers\Api\V1\Positions\GetArchivedOpenedPositionController;
use App\Http\Controllers\Api\V1\Transaction\GetArchivedTransactionsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'archives', 'as' => 'archives.'], function () {
    Route::get('/', GeArchivesController::class)->name('list');
    Route::get('/{archive}/positions/opened', GetArchivedOpenedPositionController::class)->name('opened.list');
    Route::get('/{archive}/positions/closed', GetArchivedClosedPositionController::class)->name('closed.list');
    Route::get('/{archive}/transactions', GetArchivedTransactionsController::class)->name('transactions.list');
});




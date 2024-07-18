<?php

use App\Http\Controllers\Api\V1\Transaction\GetTransactionListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
    Route::get('/', GetTransactionListController::class)->name('list');
});

<?php

use App\Http\Controllers\Api\V1\CloseMonth\CloseMonthController;
use Illuminate\Support\Facades\Route;

Route::post('/close', CloseMonthController::class)->name('close-month');



<?php

use App\Http\Controllers\Api\V1\Contact\GetContactController;
use Illuminate\Support\Facades\Route;

Route::get('/contacts', GetContactController::class)->name('contacts.list');




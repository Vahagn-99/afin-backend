<?php

use App\Http\Controllers\AmoCRM\AuthController;
use App\Http\Controllers\AmoCRM\ContactWebhookController;
use App\Http\Middleware\WebhookMiddleware;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware('web')->group(function () {
    Route::group(['prefix' => 'amocrm', 'as' => 'amocrm.'], function () {
        Route::any('/auth', [AuthController::class, 'auth']);
        Route::any('/auth/callback', [AuthController::class, 'callback']);
        Route::middleware(WebhookMiddleware::class)
            ->post('/webhooks/contacts', ContactWebhookController::class)
            ->name('webhook.contact');
    });
});

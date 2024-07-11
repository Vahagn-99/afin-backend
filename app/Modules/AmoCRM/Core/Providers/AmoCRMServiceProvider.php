<?php

namespace App\Modules\AmoCRM\Core\Providers;

use App\Modules\AmoCRM\Auth\AmoCrmAuthManager;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\AmoManager;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManager;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use App\Services\Syncer\WebhookHandler\ContactWebhookHandler;
use App\Services\Syncer\WebhookHandler\ContactWebhookHandlerInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AmoCRMServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiClient::class, function () {
            return new ApiClient(
                config('services.amocrm.client_id'),
                config('services.amocrm.client_secret'),
                config('services.amocrm.redirect_url')
            );
        });
        $this->app->singleton(AuthManagerInterface::class, AmoCrmAuthManager::class);
        $this->app->bind(AccessTokenManagerInterface::class, function () {
            return new AccessTokenManager(Storage::disk('amocrm'));
        });
        $this->app->bind(ContactWebhookHandlerInterface::class, ContactWebhookHandler::class);

        //facade
        $this->app->bind('amocrm', AmoManager::class);
    }
}

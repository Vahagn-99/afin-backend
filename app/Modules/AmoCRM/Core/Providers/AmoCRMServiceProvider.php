<?php

namespace App\Modules\AmoCRM\Core\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Modules\AmoCRM\Auth\AmoCrmAuthManager;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\AmoManager;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\Facades\Amo;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManager;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use App\Services\AmoCRM\WebhookHandlers\ContactWebhookHandler;
use App\Services\AmoCRM\WebhookHandlers\ContactWebhookHandlerInterface;
use Illuminate\Support\ServiceProvider;

class AmoCRMServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiClient::class, function () {
            $client = new ApiClient(
                config('services.amocrm.client_id'),
                config('services.amocrm.client_secret'),
                config('services.amocrm.redirect_url')
            );

//            $client->setAccountBaseDomain(config('services.amocrm.client_domain'));

            return $client;
        });
        $this->app->singleton(AuthManagerInterface::class, AmoCrmAuthManager::class);
        $this->app->bind('amocrm', AmoManager::class);
        $this->app->bind(AccessTokenManagerInterface::class, AccessTokenManager::class);
        $this->app->bind(ContactWebhookHandlerInterface::class, ContactWebhookHandler::class);
    }
}

<?php

namespace App\Modules\AmoCRM\Core\Providers;

use App\Modules\AmoCRM\Api\Contact\ContactApi;
use App\Modules\AmoCRM\Api\Contact\ContactApiInterface;
use App\Modules\AmoCRM\Api\Lead\LeadApi;
use App\Modules\AmoCRM\Api\Lead\LeadApiInterface;
use App\Modules\AmoCRM\Api\User\UserApi;
use App\Modules\AmoCRM\Api\User\UserApiInterface;
use App\Modules\AmoCRM\Api\Webhook\SubscriberInterface;
use App\Modules\AmoCRM\Api\Webhook\WebhookSubscriberApi;
use App\Modules\AmoCRM\Auth\AmoCrmAuthManager;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\AmoManager;
use App\Modules\AmoCRM\Core\AmoManagerInterface;
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
        $this->app->singleton(AmoManagerInterface::class, AmoManager::class);
        $this->app->singleton(AuthManagerInterface::class, AmoCrmAuthManager::class);
        $this->app->bind(AccessTokenManagerInterface::class, function ($app) {
            $disk = $app->environment('testing') ? 'testing' : 'amocrm';
            return new AccessTokenManager(Storage::disk($disk));
        });
        $this->app->bind(ContactWebhookHandlerInterface::class, ContactWebhookHandler::class);
        $this->app->bind('amocrm', AmoManagerInterface::class);

        //entity api client bindings
        $this->app->bind(SubscriberInterface::class, WebhookSubscriberApi::class);
        $this->app->bind(UserApiInterface::class, UserApi::class);
        $this->app->bind(ContactApiInterface::class, ContactApi::class);
        $this->app->bind(LeadApiInterface::class, LeadApi::class);
    }
}

<?php

namespace App\Providers;

use App\Modules\AmoCRM\ApiClient;
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
    }
}

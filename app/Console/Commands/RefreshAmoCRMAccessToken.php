<?php

namespace App\Console\Commands;

use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Modules\AmoCRM\Core\Facades\Amo;
use Illuminate\Console\Command;

class RefreshAmoCRMAccessToken extends Command
{
    protected $signature = 'amo:refresh-token';

    protected $description = 'The command refresh amocrm access token';

    protected int $retry = 3;

    public function handle(): void
    {
        try {
            $token = Amo::tokenizer()->getAccessToken();
            $this->info('Refreshing accessToken ...');
            $token = Amo::api()->getOAuthClient()->getAccessTokenByRefreshToken($token);
            Amo::tokenizer()->saveAccessToken($token);
            $this->info('AccessToken refreshed  successfully!');
        } catch (AmoCRMoAuthApiException $e) {
            $this->error($e->getMessage());

            if ($this->retry > 0) {
                --$this->retry;
                $this->handle();
            }
        }
    }
}

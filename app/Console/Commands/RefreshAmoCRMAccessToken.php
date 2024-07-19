<?php

namespace App\Console\Commands;

use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Modules\AmoCRM\Core\Facades\Amo;
use Illuminate\Console\Command;

class RefreshAmoCRMAccessToken extends Command
{
    protected $signature = 'amo:refresh-token';

    protected $description = 'The command refresh amocrm access token';

    /**
     * @throws AmoCRMoAuthApiException
     */
    public function handle(): void
    {
        $token = Amo::tokenizer()->getAccessToken();
        $token = Amo::api()->getOAuthClient()->getAccessTokenByRefreshToken($token);
        Amo::tokenizer()->saveAccessToken($token);
    }
}

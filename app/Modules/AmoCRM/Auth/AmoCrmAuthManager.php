<?php

namespace App\Modules\AmoCRM\Auth;


use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\Facades\Amo;

class AmoCrmAuthManager implements AuthManagerInterface
{
    const AUTH_MODE_POST_MESSAGE_TYPE = 'post_message';

    public function __construct(
        private readonly ApiClient $apiClient
    )
    {

    }

    public function url(): string
    {

        return $this->apiClient
            ->getOAuthClient()
            ->getAuthorizeUrl([
                'mode' => self::AUTH_MODE_POST_MESSAGE_TYPE,
                'state' => config('app.name'),
            ]);
    }

    /**
     * @throws AmoCRMoAuthApiException
     */
    public function exchangeCodeWithAccessToken(string $code): void
    {
        $oauth = $this->apiClient->getOAuthClient();
        $oauth->setBaseDomain(config('services.amocrm.client_domain'));
        // if no access token but there is a code from redirect
        // we can get token from that code
        $accessToken = $oauth->getAccessTokenByCode($code);
        if ($accessToken->hasExpired()) {
            $accessToken = $oauth->getAccessTokenByRefreshToken($accessToken);
        }

        Amo::tokenizer()->saveAccessToken($accessToken);
    }
}

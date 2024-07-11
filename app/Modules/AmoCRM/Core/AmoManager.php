<?php

namespace App\Modules\AmoCRM\Core;

use AmoCRM\Client\AmoCRMApiClient;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

readonly class AmoManager
{
    public function __construct(
        private ApiClient                   $client,
        private AccessTokenManagerInterface $tokenManager,
        private AuthManagerInterface        $authManager
    )
    {
    }

    public function reConnect(): AmoCRMApiClient
    {
        $this->client->setAccountBaseDomain(config('services.amocrm.client_domain'));
        $this->client->setAccessToken($this->tokenManager->getAccessToken());
        $this->client->onAccessTokenRefresh(function (AccessTokenInterface $accessToken) {
            $this->tokenManager->saveAccessToken($accessToken);
        });
        return $this->client;
    }

    public function api(): AmoCRMApiClient
    {
        $this->reConnect();
        return $this->client;
    }

    public function authenticator(): AuthManagerInterface
    {
        return $this->authManager;
    }

    public function tokenizer(): AccessTokenManagerInterface
    {
        return $this->tokenManager;
    }
}
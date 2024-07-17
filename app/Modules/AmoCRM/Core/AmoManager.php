<?php

namespace App\Modules\AmoCRM\Core;

use AmoCRM\Client\AmoCRMApiClient;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoManager implements AmoManagerInterface
{
    public function __construct(
        private readonly ApiClient                   $apiClientManager,
        private readonly AccessTokenManagerInterface $tokenManager,
        private readonly AuthManagerInterface        $authManager
    )
    {
    }

    private function reConnect(): void
    {
        $this->apiClientManager->setAccountBaseDomain(config('services.amocrm.client_domain'));
        $this->apiClientManager->setAccessToken($this->tokenManager->getAccessToken());
        $this->apiClientManager->onAccessTokenRefresh(function (AccessTokenInterface $accessToken) {
            $this->tokenManager->saveAccessToken($accessToken);
        });
    }

    public function api(): AmoCRMApiClient
    {
        $this->reConnect();
        return $this->apiClientManager;
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
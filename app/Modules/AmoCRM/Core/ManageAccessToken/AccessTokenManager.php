<?php

namespace App\Modules\AmoCRM\Core\ManageAccessToken;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

readonly class AccessTokenManager implements AccessTokenManagerInterface
{
    public function __construct(
        private Filesystem $storage
    )
    {
    }

    public function getAccessToken(): AccessToken
    {
        $fromFile = json_decode($this->storage->get('access_token.json'), true);
        return new AccessToken($fromFile);
    }

    public function saveAccessToken(AccessTokenInterface $token): void
    {
        $this->storage->put('access_token.json', json_encode($token, JSON_PRETTY_PRINT));
    }
}
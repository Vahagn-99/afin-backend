<?php

namespace App\Modules\AmoCRM\Core\ManageAccessToken;

use Illuminate\Support\Facades\Storage;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AccessTokenManager implements AccessTokenManagerInterface
{
    public function getAccessToken(): AccessToken
    {
        $fromFile = json_decode(Storage::disk('amocrm')->get('access_token.json'), true);
        return new AccessToken($fromFile);
    }

    public function saveAccessToken(AccessTokenInterface $token): void
    {
        Storage::disk('amocrm')->put('access_token.json', json_encode($token, JSON_PRETTY_PRINT));
    }
}
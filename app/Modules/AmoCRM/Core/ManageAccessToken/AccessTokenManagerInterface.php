<?php

namespace App\Modules\AmoCRM\Core\ManageAccessToken;

use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface AccessTokenManagerInterface
{
    public function getAccessToken(): AccessToken;

    public function saveAccessToken(AccessTokenInterface $token): void;
}
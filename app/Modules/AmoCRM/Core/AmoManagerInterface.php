<?php

namespace App\Modules\AmoCRM\Core;

use AmoCRM\Client\AmoCRMApiClient;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;

interface AmoManagerInterface
{
    public function api(): AmoCRMApiClient;

    public function authenticator(): AuthManagerInterface;

    public function tokenizer(): AccessTokenManagerInterface;
}
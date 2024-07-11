<?php

namespace App\Modules\AmoCRM\Core\Facades;

use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\AmoManager;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ApiClient reConnect()
 * @method static ApiClient api()
 * @method static AuthManagerInterface authenticator()
 * @method static AccessTokenManagerInterface tokenizer()
 *
 * @see AmoManager
 * @mixin AuthManagerInterface
 */
class Amo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'amocrm';
    }
}
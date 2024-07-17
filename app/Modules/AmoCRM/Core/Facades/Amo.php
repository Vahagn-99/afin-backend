<?php

namespace App\Modules\AmoCRM\Core\Facades;

use AmoCRM\EntitiesServices\BaseEntity;
use AmoCRM\EntitiesServices\Contacts;
use AmoCRM\EntitiesServices\Leads;
use AmoCRM\EntitiesServices\Users;
use App\Modules\AmoCRM\Auth\AuthManagerInterface;
use App\Modules\AmoCRM\Core\AmoManager;
use App\Modules\AmoCRM\Core\ApiClient\ApiClient;
use App\Modules\AmoCRM\Core\ManageAccessToken\AccessTokenManagerInterface;
use Exception;
use Illuminate\Support\Facades\Facade;
use Illuminate\Testing\TestResponse;

/**
 * @method static ApiClient reConnect()
// * @method static Contacts contacts()
// * @method static Leads leads()
// * @method static Users users()
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

//    /**
//     * @throws Exception
//     */
//    public static function __callStatic($method, $args): BaseEntity
//    {
//        $api = Amo::api();
//        if (!(method_exists($api, $method) && is_callable([$api, $method])))
//            throw new Exception("Call to undefined method Amo::$method()");
//
//        return $api->$method(...$args);
//    }
//

    public static function fake(): void
    {
        // mock access token
        MockAmo::mockApiManager();
    }

    public static function assertAccessTokenSaved(): void
    {
        MockAmo::assertAccessTokenSaved();
    }

    public static function assertRedirectedAuthScreen(TestResponse $response): void
    {
        MockAmo::assertRedirectedAuthScreen($response);
    }
}
<?php

namespace App\Services\Syncer\Api;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Modules\AmoCRM\Core\Facades\Amo;

class UserApi
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public function getOne(int $id): array
    {
        return Amo::api()->users()->getOne($id, ['group'])->toArray();
    }
}
<?php

namespace App\Services\AmoCRM\Api;

use AmoCRM\Collections\ContactsCollection;
use AmoCRM\EntitiesServices\Contacts;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Filters\ContactsFilter;
use App\Modules\AmoCRM\Core\Facades\Amo;

class ContactApi
{

    /**
     * @throws AmoCRMMissedTokenException
     */
    private function endpoint(): Contacts
    {
        return Amo::api()->contacts();
    }

    public function list(ContactsFilter|null $filter = null): ContactsCollection
    {
        try {
            return $this->endpoint()->get($filter);
        } catch (AmoCRMApiException $e) {
            dd([
                'error' => $e->getMessage(),
                'info' => $e->getLastRequestInfo(),
                'desc' => $e->getDescription()
            ]);
        }
    }
}

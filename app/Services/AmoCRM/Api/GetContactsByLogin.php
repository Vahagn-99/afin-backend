<?php

namespace App\Services\AmoCRM\Api;

use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Filters\ContactsFilter;

class GetContactsByLogin
{
    const LOGIN_FIELD_ID = 499481;
    const ANALYTIC_FIELD_ID = 499463;

    public function __construct(private readonly ContactApi $contactApi)
    {
    }

    public function get(array $logins): ?ContactsCollection
    {
        $filter = new ContactsFilter();
        $filter->setCustomFieldsValues([self::LOGIN_FIELD_ID => $logins[0]]);
        return $this->contactApi->list($filter);
    }
}
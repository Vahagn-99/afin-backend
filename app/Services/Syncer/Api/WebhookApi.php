<?php

namespace App\Services\Syncer\Api;

use AmoCRM\EntitiesServices\Webhooks;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\WebhooksFilter;
use AmoCRM\Models\WebhookModel;
use App\Modules\AmoCRM\Core\Facades\Amo;
use function Laravel\Prompts\error;

class WebhookApi
{
    const WEBHOOK_CONTACT_ADDED = 'add_lead';
    const WEBHOOK_CONTACT_UPDATED = 'status_lead';

    public function subscribe(string $destination, array $actions): void
    {
        $amoWebhook = new  WebhookModel;
        $amoWebhook->setDestination($destination);
        $amoWebhook->setSettings($actions);

        try {
            //Подпишемся на веб хук добавления сделки
            $this->endpoint()->subscribe($amoWebhook);
        } catch (AmoCRMApiException $e) {
            error($e);
        }
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     */
    public function refresh(string $destination, array $actions): void
    {
        $amoWebhook = new  WebhookModel;
        $amoWebhook->setDestination($destination);
        $filter = new WebhooksFilter();
        $filter->setDestination($destination);
        //Подпишемся на веб хук добавления сделки
        $exists = $this->endpoint()->get($filter);

        if ($exists) {
            $this->endpoint()->unsubscribe($exists->current());
        }

        $amoWebhook->setSettings($actions);
        $this->endpoint()->subscribe($amoWebhook);
    }

    /**
     * @throws AmoCRMoAuthApiException
     */
    protected function endpoint(): Webhooks
    {
        try {
            return Amo::api()->webhooks();
        } catch (AmoCRMMissedTokenException $e) {
            error($e);
            throw new AmoCRMoAuthApiException("Token is required");
        }
    }
}

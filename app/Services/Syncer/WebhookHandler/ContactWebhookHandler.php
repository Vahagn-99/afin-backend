<?php

namespace App\Services\Syncer\WebhookHandler;

use App\DTO\SaveContactDTO;
use App\Services\Syncer\Config\Config;
use App\Services\Syncer\Mapper\CustomFieldFromWebhookMapper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

readonly class ContactWebhookHandler implements ContactWebhookHandlerInterface
{
    public function __construct(
        private CustomFieldFromWebhookMapper $customFieldFromWebhookMapper,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $data): SaveContactDTO
    {
        Log::driver('amocrm')->debug('the webhook data', $data);
        $contact = current(current($data['contacts']));
        $customFields = $this->customFieldFromWebhookMapper->handle($contact);
        if (!in_array(Config::LOGIN_FIELD_ID, array_keys($customFields))) throw new Exception("Missing login field");

        return new SaveContactDTO(
            id: $contact['id'],
            name: $contact['name'],
            login: $customFields[Config::LOGIN_FIELD_ID],
            url: sprintf(config('services.amocrm.contact_url'), $contact['id']),
            manager_id: $contact['responsible_user_id'],
            analytic: Arr::get($customFields, Config::ANALYTIC_FIELD_ID),
        );
    }
}
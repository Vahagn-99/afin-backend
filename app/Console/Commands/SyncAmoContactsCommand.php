<?php

namespace App\Console\Commands;

use AmoCRM\Filters\ContactsFilter;
use App\DTO\SaveContactDTO;
use App\Modules\AmoCRM\Api\Contact\ContactApi;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Services\Syncer\Config\Config;
use App\Services\Syncer\Mapper\CustomFieldFromApiMapper;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncAmoContactsCommand extends Command
{
    protected $signature = 'amo:contacts';

    public function __construct(
        private readonly ContactApi                 $contactApi,
        private readonly ContactRepositoryInterface $contactRepository,
        private readonly CustomFieldFromApiMapper   $cfMapper,
    )
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $contacts = $this->getContacts();

        foreach ($contacts as $contact) {
            try {
                $dto = $this->mapContactFromArrayToDTO($contact);
                $this->contactRepository->save($dto);
                $this->info("The contact was successfully saved $dto->id");
            } catch (Exception $e) {
                $this->warn("skipped the contact {$contact['id']}");
                $this->warn($e->getMessage());
                continue;
            }
        }
    }

    /**
     * @throws Exception
     */
    private function mapContactFromArrayToDTO(array $contact): SaveContactDTO
    {
        $customFields = $this->cfMapper->handle($contact);
        if (!in_array(Config::LOGIN_FIELD_ID, array_keys($customFields))) throw new Exception("The login field is missing.");

        return new SaveContactDTO(
            id: $contact['id'],
            name: $contact['name'],
            login: $customFields[Config::LOGIN_FIELD_ID],
            url: sprintf(config('services.amocrm.contact_url'), $contact['id']),
            manager_id: $contact['responsible_user_id'],
            analytic: Arr::get($customFields, Config::ANALYTIC_FIELD_ID),
        );
    }

    private function getContacts(): array
    {
        $filter = new ContactsFilter();
        $filter->setOrder('created_at', 'desc');
        $filter->setLimit(100);

        return $this->contactApi->get($filter)->toArray();
    }
}

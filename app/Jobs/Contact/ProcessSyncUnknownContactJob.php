<?php

namespace App\Jobs\Contact;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\DTO\SaveContactDTO;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Services\Syncer\Api\ContactApi;
use App\Services\Syncer\Api\UserApi;
use App\Services\Syncer\Extractor\CustomFieldExtractor;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessSyncUnknownContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private ContactRepositoryInterface $contactRepository,
        private ContactApi                 $contactApi,
        protected UserApi                  $userApi
    )
    {
        //
    }

    public function handle(): void
    {
//        $logins = $this->getUnknownContactsLogins();
//        $contacts = $this->contactApi->get()->toArray();
//        foreach ($contacts as $contact) {
//            try {
//                $customFields = CustomFieldExtractor::handle($contact);
//                $user = $this->userApi->getOne($contact['responsible_user_id']);
//                $this->contactRepository->save(new SaveContactDTO(
//                    $contact['id'],
//                    $contact['name'],
//                    $contact['login'],
//                // TODO: complete this
//                ));
//            } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException|AmoCRMApiException|Exception $e) {
//                continue;
//            }
//        }
    }

    public function getUnknownContactsLogins(): array
    {
        // Get unknown contacts from transactions
        $unknownContactsFromTransactions = DB::table('transactions')
            ->select('login')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('contacts')
                    ->whereColumn('contacts.login', 'transactions.login');
            });

        // Get unknown contacts from positions
        $unknownContactsFromPositions = DB::table('positions')
            ->select('login')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('contacts')
                    ->whereColumn('contacts.login', 'positions.login');
            });

        // Combine both queries with a union
        return $unknownContactsFromTransactions
            ->union($unknownContactsFromPositions)
            ->pluck('login')
            ->toArray();
    }
}

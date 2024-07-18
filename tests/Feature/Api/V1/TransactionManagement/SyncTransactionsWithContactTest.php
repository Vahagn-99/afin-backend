<?php

namespace Tests\Feature\Api\V1\TransactionManagement;

use App\Models\Contact;
use App\Models\Transaction;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class SyncTransactionsWithContactTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_synced_with_contacts_filtered(): void
    {
        // fake
        $transactions = collect();
        $contacts = Contact::factory()->count(3)->create();
        foreach ($contacts as $contact) {
            $transactions->add(Transaction::factory()
                ->create(['login' => $contact->login])
            );
        }

        //request
        $response = $this->json('get', '/api/v1/transactions');

        //assertion
        $response->assertStatus(200);

        foreach ($transactions as $transaction) {
            foreach ($contacts as $contact) {
                if ($contact->id === $transaction->contact_id) {
                    $response->assertJsonFragment([
                        'login' => $transaction->login,
                        'client' => $contact->client,
                        'branch' => $contact->branch,
                        'analytic' => $contact->analytic,
                        'manager' => $contact->manager,
                    ]);
                }
            }
        }
    }
}

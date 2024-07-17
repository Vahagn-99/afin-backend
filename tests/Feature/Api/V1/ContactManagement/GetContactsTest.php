<?php

namespace Tests\Feature\Api\V1\ContactManagement;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetContactsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_contacts_list(): void
    {
        // fake
        Config::set('services.amocrm.contact_url', 'https://afininvest.amocrm.ru/contacts/detail/%s');
        /** @var Collection<Contact> $contacts */
        $contacts = Contact::factory()->count(10)->create();
        //request
        $response = $this->json('get', '/api/v1/contacts');
        //assertion
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        foreach ($contacts as $contact) {

            $response->assertJsonFragment([
                'id' => $contact->id,
                'name' => $contact->name,
                'manager_id' => $contact->manager_id,
                'analytic' => $contact->analytic,
                'login' => $contact->login,
                'url' => sprintf(config('services.amocrm.contact_url'), $contact->id)
            ]);
        }
    }
}

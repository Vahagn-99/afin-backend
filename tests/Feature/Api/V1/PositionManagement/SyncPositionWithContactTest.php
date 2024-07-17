<?php

namespace Tests\Feature\Api\V1\PositionManagement;

use App\Models\Contact;
use App\Models\Position;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class SyncPositionWithContactTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_positions_synced_with_contacts_filtered(): void
    {
        // fake
        $positions = collect();
        $contacts = Contact::factory()->count(3)->create();
        foreach ($contacts as $contact) {
            $positions->add(Position::factory()
                ->create([
                    'login' => $contact->login,
                    'closed_at' => now()->subDays(30),
                ])
            );
        }

        //request
        $response = $this->json('get', '/api/v1/positions/closed');

        //assertion
        $response->assertStatus(200);

        foreach ($positions as $position) {
            foreach ($contacts as $contact) {
                if ($contact->login === $position->login) {
                    $response->assertJsonFragment([
                        'id' => $position->id,
                        'name' => $contact->name,
                        'analytic' => $contact->analytic,
                        'manager_id' => $contact->manager_id,
                    ]);
                }
            }
        }
    }
}

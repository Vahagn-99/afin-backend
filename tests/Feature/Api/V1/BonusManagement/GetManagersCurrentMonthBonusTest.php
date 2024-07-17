<?php

namespace Tests\Feature\Api\V1\BonusManagement;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerBonus;
use App\Models\Transaction;
use Random\RandomException;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetManagersCurrentMonthBonusTest extends TestCase
{
    use HasAuthUser;

    /**
     * @throws RandomException
     */
    public function test_user_can_get_managers_current_month_bonuses(): void
    {
        $deposit = 50;
        $lots = 20;
        $prevMonthPayoff = 20;

        $manager = Manager::factory()->create();

        $login1 = random_int(45, 5454545);
        $login2 = random_int(900, 5689985);
        $login3 = random_int(45487, 77777);
        $contacts[] = Contact::factory()->create([
            'manager_id' => $manager->id,
            'login' => $login1,
        ]);
        $contacts[] = Contact::factory()->create([
            'manager_id' => $manager->id,
            'login' => $login2,
        ]);
        $contacts[] = Contact::factory()->create([
            'manager_id' => $manager->id,
            'login' => $login3,
        ]);
        Transaction::factory()->create([
            'login' => $login1,
            'currency' => 'RUB',
            'deposit' => $deposit,
            'withdrawal' => 60,
            'volume_lots' => $lots,
            'equity' => 20,
            'balance_end' => 700,
            'commission' => 30,
        ]);
        Transaction::factory()->create([
            'login' => $login2,
            'currency' => 'RUB',
            'deposit' => $deposit,
            'withdrawal' => 60,
            'volume_lots' => $lots,
            'equity' => 20,
            'balance_end' => 700,
            'commission' => 30,
        ]);
        Transaction::factory()->create([
            'login' => $login3,
            'currency' => 'RUB',
            'deposit' => $deposit,
            'withdrawal' => 60,
            'volume_lots' => $lots,
            'equity' => 20,
            'balance_end' => 700,
            'commission' => 30,
        ]);

        foreach ($contacts as $contact) {
            ManagerBonus::factory()->create([
                'manager_id' => $manager->id,
                'contact_id' => $contact->id,
                'payoff' => $prevMonthPayoff,
                'date' => now()->subMonth()->format('Y-m-d'),
            ]);
        }

        //request
        $response = $this->json('get', "/api/v1/managers/bonuses/current");

        //assertion
        foreach ($contacts as $contact) {
            $response->assertJsonFragment([
                'manager_name' => $manager->name,
                'manager_branch' => $manager->branch,
                'manager_id' => $manager->id,
                'contact_id' => $contact->id,
                'deposit' => $deposit,
                'volume_lots' => $lots,
                'bonus' => $deposit * 0.02,
                'potential_bonus' => $deposit * 0.02 - $lots * 100,
                'payoff' => $lots * 100,
                'paid' => $prevMonthPayoff,
                'date' => now()->format('Y-m-d'),
            ]);
        }

        $response->assertStatus(200);
    }
}

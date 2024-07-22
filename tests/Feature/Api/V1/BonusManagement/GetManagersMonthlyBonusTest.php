<?php

namespace Tests\Feature\Api\V1\BonusManagement;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerBonus;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetManagersMonthlyBonusTest extends TestCase
{
    use HasAuthUser;


    public function test_user_can_get_managers_monthly_bonuses(): void
    {
        $month = now()->subMonth();
        $manager = Manager::factory()->create();
        $contact = Contact::factory()->create(['manager_id' => $manager->id]);
        $bonuses = collect();
        $bonuses->add(
            ManagerBonus::factory()->create([
                'date' => $month->format('Y-m-d'),
                'manager_id' => $manager->id,
                'contact_id' => $contact->id,
            ])
        );
        $bonuses->add(
            ManagerBonus::factory()->create([
                'date' => $month->format('Y-m-d'),
                'manager_id' => $manager->id,
                'contact_id' => $contact->id,
            ])
        );

        //request
        $response = $this->json('get', "/api/v1/managers/bonuses/monthly", [
            'filters' => [
                'date' => $month->format('Y-m-d'),
            ]
        ]);

        //assertion
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'manager_name' => $manager->name,
            'manager_id' => $manager->id,
            'contact_id' => $contact->id,
            'deposit' => round($bonuses->sum('deposit'), 2),
            'volume_lots' => round($bonuses->sum('volume_lots'), 2),
            'bonus' => round($bonuses->sum('bonus'), 2),
            'potential_bonus' => round($bonuses->sum('potential_bonus'), 2),
            'payoff' => round($bonuses->sum('payoff'), 2),
            'paid' => round($bonuses->sum('paid'), 2),
            'date' => $month->format('Y-m-d'),
        ]);
    }
}

<?php

namespace Tests\Feature\Api\V1\RatingManagement;

use App\Models\Manager;
use App\Models\ManagerRating;
use App\Services\Syncer\Config\Config;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetManagersMonthlyRatingTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_managers_monthly_rating(): void
    {
        $date = now()->subMonths(7)->format('Y-m');
        /** @var Collection<Manager> $managers */
        $managers = Manager::factory(5)->create();
        foreach ($managers as $key => $manager) {
            ManagerRating::factory()->create([
                'manager_id' => $manager->getKey(),
                'total' => 50 * $key,
                'type' => Config::RATING_TYPE_LEADS_TOTAL,
                'date' => now()->subMonths(10 - $key)->format('Y-m-d'),
            ]);
            ManagerRating::factory()->create([
                'manager_id' => $manager->getKey(),
                'total' => 60 * $key,
                'type' => Config::RATING_TYPE_DEPOSIT_TOTAL,
                'date' => now()->subMonths(10 - $key)->format('Y-m-d'),
            ]);
        }

        //request
        $response = $this->json('get', "/api/v1/managers/ratings/monthly/$date");

        //assertion
        $response->assertStatus(200);
        $manager = $managers->filter(fn($manager, $key) => $key === 3)->first();
        $response->assertJsonFragment([
            'id' => $manager->id,
            'name' => $manager->name,
            'avatar' => $manager->avatar,
            'branch' => $manager->branch,
            'type' => $manager->type,
            'date' => $date,
            'leads_total' => 50 * 3,
            'deposit_total' => 60 * 3
        ]);
    }
}

<?php

namespace Tests\Feature\Api\V1\RatingManagement;

use App\Models\Manager;
use App\Models\ManagerRating;
use App\Services\Syncer\Config\Config;
use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetManagersRatingHistoryTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_managers_rating_history(): void
    {
        $expectedData = [];
        $startDate = Carbon::create('2024-07-01');
        for ($i = 0; $i < 5; $i++) {
            $date = $startDate->subMonths($i);
            ManagerRating::factory()->create([
                'date' => $date->format('Y-m-d'),
                'manager_id' => Manager::factory()->create()->getKey(),
                'total' => 50 * $i
            ]);
            $expectedData[] = [
                'date' => $date->format('Y-n'),
                'name' => "Рейтинг за " . $date->setLocalTranslator(Translator::get('ru'))->monthName . ' ' . $date->year
            ];
        }

        //request
        $response = $this->json('get', "/api/v1/managers/ratings/histories");

        //assertion
        $response->assertStatus(200);
        foreach ($expectedData as $date) {
            $response->assertJsonFragment([
                'date' => $date['date'],
                'name' => $date['name'],
            ]);
        }
    }
}

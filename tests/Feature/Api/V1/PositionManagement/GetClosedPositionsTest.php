<?php

namespace Tests\Feature\Api\V1\PositionManagement;

use App\Models\Position;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetClosedPositionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_closed_positions(): void
    {
        // fake
        $openPositions = Position::factory()->count(20)->create([
            'closed_at' => null
        ]);

        $closePositions = Position::factory()->count(20)->create(); // closed positions

        //request
        $response = $this->json('get', '/api/v1/positions/closed?per_page=30&page=1');

        //assertion
        $response->assertStatus(200);
        $response->assertJsonCount(20, 'data');
        $response->assertJsonStructure(['data' =>
            [
                '*' => [
                    'id',
                    'login',
                    'utm',
                    'opened_at',
                    'closed_at',
                    'action',
                    'symbol',
                    'lead_volume',
                    'price',
                    'profit',
                    'reason',
                    'currency',
                    'position',
                ]
            ]
        ]);
        foreach ($closePositions as $position) {
            $response->assertJsonFragment([
                'id' => $position->id,
            ]);
        }
        foreach ($openPositions as $position) {
            $response->assertJsonMissing([
                'id' => $position->id,
            ]);
        }
    }
}

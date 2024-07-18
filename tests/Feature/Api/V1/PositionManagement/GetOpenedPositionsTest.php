<?php

namespace Tests\Feature\Api\V1\PositionManagement;

use App\Models\Position;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetOpenedPositionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_opened_positions(): void
    {
        // fake
        $openPositions = Position::factory()->count(20)->create([
            'closed_at' => null
        ]);

        $closePositions = Position::factory()->count(20)->create(); // closed positions

        //request
        $response = $this->json('get', '/api/v1/positions/opened?per_page=30&page=1');

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
                    'updated_at',
                    'action',
                    'symbol',
                    'lead_volume',
                    'price',
                    'reason',
                    'float_result',
                    'currency',
                    'position',
                ]
            ]
        ]);
        foreach ($openPositions as $position) {
            $response->assertJsonFragment([
                'id' => $position->id,
            ]);
        }
        foreach ($closePositions as $position) {
            $response->assertJsonMissing([
                'id' => $position->id,
            ]);
        }
    }
}

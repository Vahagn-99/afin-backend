<?php

namespace Tests\Feature\Api\V1\PositionManagement;

use App\Models\ArchivedPosition;
use App\Models\Archive;
use App\Models\Position;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetArchivedOpenPositionsTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_archived_opened_positions(): void
    {
        // fake
        $positions = ArchivedPosition::factory()->count(20)->create([
            'archive_id' => $history = Archive::factory()->create()->id,
            'closed_at' => null,
        ]);

        //request
        $response = $this->json('get', "/api/v1/archives/$history/positions/opened");

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
        foreach ($positions as $position) {
            $response->assertJsonFragment([
                'id' => $position->id,
            ]);
        }
    }
}

<?php

namespace Tests\Feature\Api\V1\ArchiveManagement;

use App\Models\Archive;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetArchivesListTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_transactions_archive_list(): void
    {
        // fake
        $archives = Archive::factory(5)->create();

        //request
        $response = $this->json('get', "/api/v1/archives");

        //assertion
        $response->assertStatus(200);

        foreach ($archives as $archive) {
            $response->assertJsonFragment([
                'id' => $archive->id,
                'from' => $archive->from,
                'to' => $archive->to,
                'closet_at' => $archive->closet_at,
                'created_at' => $archive->created_at,
            ]);
        }
    }
}

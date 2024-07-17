<?php

namespace Tests\Feature\Api\V1\ManagerManagement;

use App\Models\Contact;
use App\Models\Manager;
use App\Models\ManagerBonus;
use App\Models\Transaction;
use Random\RandomException;
use Tests\TestCase;
use Tests\Traits\HasAuthUser;

class GetManagersListTest extends TestCase
{
    use HasAuthUser;

    public function test_user_can_get_managers_list(): void
    {
        $managers = Manager::factory(5)->create();

        //request
        $response = $this->json('get', "/api/v1/managers");

        //assertion
        $response->assertStatus(200);
        foreach ($managers as $manager) {
            $response->assertJsonFragment([
                'id' => $manager->id,
                'name' => $manager->name,
                'branch' => $manager->branch,
            ]);
        }
    }
}

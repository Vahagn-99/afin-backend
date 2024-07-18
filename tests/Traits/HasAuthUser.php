<?php

namespace Tests\Traits;

use App\Models\User;
use Laravel\Sanctum\Guard;
use Laravel\Sanctum\Sanctum;

trait HasAuthUser
{
    private User $user;
    public function authUser(array $params = []): void
    {
        $this->actingAs($this->user = User::factory()->create($params));
    }
}
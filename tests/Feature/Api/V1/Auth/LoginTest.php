<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_admin_can_login_successfully(): void
    {
        //fake
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        //request
        $response = $this->json('post', '/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        //assertion
        $response->assertStatus(200);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
        $response->assertJsonStructure([
            'id',
            'access_token'
        ]);
    }

    public function test_admin_can_logout_successfully(): void
    {
        //fake
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        //request
        $response = $this->json('post', '/api/v1/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        //assertion
        $response->assertNoContent();
        $this->assertDatabaseEmpty('personal_access_tokens');
    }
}

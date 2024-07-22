<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User|Authenticatable $user */
        $user = User::factory()->create([
            'email' => 'admin@afin-panel.ru',
            'password' => bcrypt('04xNyZw5'),
        ]);

        $user->tokens()->create([
            'name' => 'amocrm',
            'token' => hash('sha256', config('auth.admin_default_access_token')),
            'abilities' => ['*'],
            'expires_at' => null,
        ]);
    }
}

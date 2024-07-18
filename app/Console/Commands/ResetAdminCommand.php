<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ResetAdminCommand extends Command
{
    protected $signature = 'reset:admin';

    public function handle()
    {
        $password = Str::random(8);
        do {
            $email = $this->ask('What is your email?');
        } while (is_null($email));

        /** @var User $admin */
        $admin = User::query()->first();
        $admin->password = bcrypt($password);
        $admin->email = $email;
        $admin->save();
        $this->info('Admin reset successfully. email: ' . $email . ' password: ' . $password);
    }
}

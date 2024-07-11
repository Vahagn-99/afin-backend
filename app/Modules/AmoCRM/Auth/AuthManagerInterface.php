<?php

namespace App\Modules\AmoCRM\Auth;


interface AuthManagerInterface
{
    const AUTH_MODE_POST_MESSAGE_TYPE = 'post_message';

    public function url(): string;

    public function exchangeCodeWithAccessToken(string $code): void;
}

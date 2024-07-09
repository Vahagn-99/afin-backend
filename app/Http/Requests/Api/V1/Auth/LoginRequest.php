<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string'
        ];
    }


    /**
     * @throws ValidationException
     */
    public function authenticate(): User|Authenticatable
    {
        $credentials = $this->validated();

        /** @var User $user */
        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user) throw ValidationException::withMessages([
            'email' => ['The provided email are incorrect.'],
        ]);

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password are incorrect.'],
            ]);
        }

        return $user;
    }
}

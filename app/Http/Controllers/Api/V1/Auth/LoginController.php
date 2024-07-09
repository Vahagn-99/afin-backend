<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();
        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'id' => $user->getKey()
        ]);
    }

    public function logout(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->noContent();
    }
}

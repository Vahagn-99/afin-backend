<?php

namespace App\Http\Middleware;

use App\Models\WebhookClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!app()->environment('production')) return $next($request);

        $clientId = $request->input('client_id');
        $clientApiKey = $request->input('api_key');

        $exists = WebhookClient::whereValid($clientId, $clientApiKey)->exists();

        if (!$exists) return response()->json(['Unrecognized request'], Response::HTTP_UNAUTHORIZED);

        return $next($request);
    }
}

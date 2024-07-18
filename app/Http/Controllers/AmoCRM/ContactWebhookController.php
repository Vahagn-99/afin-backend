<?php

namespace App\Http\Controllers\AmoCRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmoCRM\Webhooks\ContactWebhookRequest;
use App\Jobs\Contact\ProcessHandleContactJob;
use Illuminate\Http\JsonResponse;

class ContactWebhookController extends Controller
{
    public function __invoke(ContactWebhookRequest $request): JsonResponse
    {

        ProcessHandleContactJob::dispatch($request->all())->afterResponse();
        return response()->json(["message" => 'successfully processed']);
    }
}
<?php

namespace App\Http\Controllers\AmoCRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmoCRM\Webhooks\ContactWebhookRequest;
use App\Jobs\Contact\ProcessHandleContactFromAmoCRMWebhookJob;
use Illuminate\Http\JsonResponse;

class ContactWebhookController extends Controller
{
    public function __invoke(ContactWebhookRequest $request): JsonResponse
    {

        ProcessHandleContactFromAmoCRMWebhookJob::dispatch($request->all())->afterResponse();
        return response()->json(["message" => 'successfully processed']);
    }
}
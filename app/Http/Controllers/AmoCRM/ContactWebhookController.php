<?php

namespace App\Http\Controllers\AmoCRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmoCRM\Webhooks\ContactWebhookRequest;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Services\AmoCRM\WebhookHandlers\ContactWebhookHandlerInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class ContactWebhookController extends Controller
{
    public function __construct(
        private readonly ContactWebhookHandlerInterface $webhookHandler,
        private readonly ContactRepositoryInterface     $contactRepository,
    )
    {
    }

    public function __invoke(ContactWebhookRequest $request): JsonResponse
    {

        try {
            $contact = $this->webhookHandler->handle($request->validated());
            $this->contactRepository->save($contact);
            return response()->json(["message" => 'successfully processed']);
        } catch (Exception $e) {
            logger($e->getMessage());
            return response()->json([
                "message" => 'unfortunately something went wrong',
                "error" => $e->getMessage()
            ]);
        }
    }
}
<?php

namespace App\Jobs\Contact;

use App\Repositories\Contact\ContactRepositoryInterface;
use App\Services\Syncer\WebhookHandler\ContactWebhookHandlerInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessHandleContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly array $data)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(
        ContactWebhookHandlerInterface $webhookHandler,
        ContactRepositoryInterface     $contactRepository,
    ): void
    {
        $contact = $webhookHandler->handle($this->data);
        $contactRepository->save($contact);
    }

    public function fail($exception = null): void
    {
        logger($exception);
    }
}

<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\ImportFinished;

class SyncTransactionsWithAmoCRMContacts
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ImportFinished $event): void
    {
        //
    }
}

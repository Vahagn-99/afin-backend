<?php

namespace App\Listeners\Contact;

use App\Events\Transaction\ImportChunkFinished;
use Illuminate\Support\Facades\DB;

class SyncUnknownContacts
{

    public function __construct()
    {

    }


    public function handle(ImportChunkFinished $event): void
    {
        $unknownContacts = DB::table('transactions')
            ->select('login')
            ->whereDoesntHave('login')
            ->union('positions')
            ->select('login')
            ->whereDoesntHave('login');
    }
}

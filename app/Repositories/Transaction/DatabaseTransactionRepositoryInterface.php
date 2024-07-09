<?php

namespace App\Repositories\Transaction;

interface DatabaseTransactionRepositoryInterface extends TransactionRepositoryInterface
{
    public function truncate(): void;
}
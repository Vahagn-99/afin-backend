<?php

namespace App\Repositories\Transaction;


interface FileSystemTransactionRepositoryInterface extends TransactionRepositoryInterface
{
    public function getTransactionsByJsonFilePath(string $path):array;
}
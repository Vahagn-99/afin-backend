<?php

namespace App\Services\CloseTransaction;

use App\DTO\CloseTransactionsMonthDTO;

interface CloseTransactionServiceInterface
{
    public function closeTransaction(CloseTransactionsMonthDTO $dto);
}

<?php

namespace App\Services\CloseTransaction;

use App\DTO\CloseMonthDTO;

interface CloseMonthServiceInterface
{
    public function closeMonth(CloseMonthDTO $dto);
}

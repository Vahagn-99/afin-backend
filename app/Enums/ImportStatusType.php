<?php

namespace App\Enums;

enum ImportStatusType: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_COMPLETED = 'completed';
    case STATUS_FAILED = 'failed';

    public function isFinished(): bool
    {
        return $this === self::STATUS_COMPLETED;
    }
}
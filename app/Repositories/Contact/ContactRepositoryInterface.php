<?php

namespace App\Repositories\Contact;

use App\DTO\SaveContactDTO;

interface ContactRepositoryInterface
{
    public function save(SaveContactDTO $amoContactDTO): array;
}
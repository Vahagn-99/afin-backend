<?php

namespace App\DTO;

class SaveManagerDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $branch,
        public string  $type = 'manager',
        public ?string $avatar = null,
    )
    {
    }
}
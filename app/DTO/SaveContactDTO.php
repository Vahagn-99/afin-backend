<?php

namespace App\DTO;

class SaveContactDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public int     $login,
        public ?string $analytic = null,
        public ?string $manager = null,
        public ?string $branch = null,
    )
    {
    }
}
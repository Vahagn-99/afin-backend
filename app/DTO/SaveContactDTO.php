<?php

namespace App\DTO;

class SaveContactDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public int     $login,
        public string  $url,
        public int     $manager_id,
        public ?string $analytic = null,
    )
    {
    }
}
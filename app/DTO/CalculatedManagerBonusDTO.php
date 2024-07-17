<?php

namespace App\DTO;

class CalculatedManagerBonusDTO
{
    public function __construct(
        public string     $manager_name,
        public string     $manager_branch,
        public int        $manager_id,
        public int        $contact_id,
        public float      $deposit,
        public float      $volume_lots,
        public float      $bonus,
        public float      $potential_bonus,
        public float      $payoff,
        public float|null $paid,
        public string     $date,
    )
    {
    }
}
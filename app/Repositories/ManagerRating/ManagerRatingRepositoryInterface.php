<?php

namespace App\Repositories\ManagerRating;

use App\DTO\SaveManagerRatingDTO;

interface ManagerRatingRepositoryInterface
{
    public function save(SaveManagerRatingDTO $managerRatingDTO): array;

}
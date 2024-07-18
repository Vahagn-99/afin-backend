<?php

namespace App\Repositories\ManagerRating;

use App\DTO\SaveManagerRatingDTO;
use App\Models\ManagerRating;
use App\Repositories\Core\RepositoryFather;

class ManagerRatingRepository extends RepositoryFather implements ManagerRatingRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = ManagerRating::query();
    }

    public function save(SaveManagerRatingDTO $managerRatingDTO): array
    {
        $manager = $this->getQuery()->updateOrCreate(
            [
                'date' => $managerRatingDTO->date,
                'manager_id' => $managerRatingDTO->managerId,
                'type' => $managerRatingDTO->type,
            ],
            [
                'total' => $managerRatingDTO->total
            ]
        );
        return $manager->toArray();
    }
}
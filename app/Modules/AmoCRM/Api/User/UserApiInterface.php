<?php

namespace App\Modules\AmoCRM\Api\User;

use AmoCRM\Filters\BaseEntityFilter;

interface UserApiInterface
{
    public function getOne(int $id): array;

    public function get(BaseEntityFilter|null $filter = null, array $with = ['group']): array;
}
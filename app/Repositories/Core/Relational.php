<?php

namespace App\Repositories\Core;

interface Relational
{
    public function with(array $relations): static;
}
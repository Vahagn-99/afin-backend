<?php

namespace App\Repositories\Core;

trait HasRelations
{
    public function with(array $relations): static
    {
        if (!$this instanceof Relational) return $this;
        $this->getQuery()->with($relations);
        return $this;
    }
}
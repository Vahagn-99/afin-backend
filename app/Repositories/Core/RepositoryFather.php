<?php

namespace App\Repositories\Core;


use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class RepositoryFather
{
    protected Builder $query;

    abstract protected function setQuery(): void;

    protected function getQuery(): Builder
    {
        if (!isset($this->query)) {
            $this->setQuery();
        }

        return $this->query;
    }

    protected function newQuery(): Builder
    {
        return $this->query->newQuery();
    }
}
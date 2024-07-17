<?php

namespace App\Repositories\Contact;

use App\DTO\PaginationDTO;
use App\DTO\SaveContactDTO;
use App\Models\Contact;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ContactRepository extends RepositoryFather implements ContactRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = Contact::query();
    }

    public function save(SaveContactDTO $amoContactDTO): array
    {
        $contact = $this->getQuery()->updateOrCreate(
            ['id' => $amoContactDTO->id],
            [
                'name' => $amoContactDTO->name,
                'login' => $amoContactDTO->login,
                'analytic' => $amoContactDTO->analytic,
                'manager_id' => $amoContactDTO->manager_id,
                'url' => $amoContactDTO->url,
            ]
        );
        return $contact->toArray();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page,
            );
    }

    public function getOnly(string|array $string, FiltersAggregor $filter): array
    {
        return $this->getQuery()
            ->select(Arr::wrap($string))
            ->filter($filter)
            ->get()
            ->toArray();
    }

    public function getAll(FiltersAggregor $filter): array
    {
        return $this->getQuery()
            ->filter($filter)
            ->get()
            ->toArray();
    }
}
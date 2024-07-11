<?php

namespace App\Repositories\Contact;

use App\DTO\SaveContactDTO;
use App\Models\Contact;
use App\Repositories\Core\RepositoryFather;

class ContactRepository extends RepositoryFather implements ContactRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = Contact::query();
    }

    public function save(SaveContactDTO $amoContactDTO): array
    {
        $contact = $this->getQuery()->updateOrCreate(
            ['id' => $amoContactDTO->id],
            [
                'client' => $amoContactDTO->name,
                'login' => $amoContactDTO->login,
                'analytic' => $amoContactDTO->analytic,
                'branch' => $amoContactDTO->branch,
                'manager' => $amoContactDTO->manager,
            ]
        );
        return $contact->toArray();
    }
}
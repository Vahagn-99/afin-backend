<?php

namespace App\Repositories\Position;

use App\DTO\PaginationDTO;
use App\Models\ArchivedPosition;
use App\Models\Position;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArchivedPositionRepository extends RepositoryFather implements ArchivedPositionRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = ArchivedPosition::query();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page
            );
    }

    public function getAll(?FiltersAggregor $aggregator = null): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
    }

    public function saveBatchByArchiveId(int $archiveId, array $positions): void
    {
        $chunks = array_chunk($positions, 1000, true);
        foreach ($chunks as $chunk) {
            $positions = array_map(function (array $position) use ($archiveId) {
                $position['archive_id'] = $archiveId;
                return $position;
            }, $chunk);

            DB::table('archived_positions')->upsert($positions, ['login', 'position']);
        }
    }
}
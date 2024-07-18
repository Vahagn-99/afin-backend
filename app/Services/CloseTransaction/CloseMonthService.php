<?php

namespace App\Services\CloseTransaction;

use App\DTO\CloseMonthDTO;
use App\DTO\SaveArchiveDTO;
use App\Repositories\Archive\ArchiveRepositoryInterface;
use App\Repositories\ArchivedTransaction\ArchivedTransactionRepositoryInterface;
use App\Repositories\Position\ArchivedPositionRepositoryInterface;
use App\Repositories\Position\PositionRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Support\Carbon;

readonly class CloseMonthService implements CloseMonthServiceInterface
{
    public function __construct(
        private ArchiveRepositoryInterface             $archiveRepository,
        private ArchivedTransactionRepositoryInterface $archivedTransactionRepository,
        private ArchivedPositionRepositoryInterface    $archivedPositionRepository,
        private TransactionRepositoryInterface         $transactionRepository,
        private PositionRepositoryInterface            $positionRepository
    )
    {
    }

    public function closeMonth(CloseMonthDTO $dto): void
    {
        $transactions = $this->transactionRepository->getAll();
        $positions = $this->positionRepository->getAll();

        $this->transactionRepository->truncate();
        $this->positionRepository->truncate();

        $closedMonth = Carbon::create($dto->closedAt);
        $archiveId = $this->archiveRepository->save(new SaveArchiveDTO(
            from: $closedMonth->copy()->startOfMonth()->format("Y-m-d H:i:s"),
            to: $closedMonth->copy()->endOfMonth()->format("Y-m-d H:i:s"),
            closet_at: $closedMonth->format("Y-m-d")
        ));
        $this->archivedPositionRepository->saveBatchByArchiveId($archiveId, $positions);
        $this->archivedTransactionRepository->saveBatchByArchiveId($archiveId, $transactions);
    }
}

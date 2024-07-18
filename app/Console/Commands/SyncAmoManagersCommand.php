<?php

namespace App\Console\Commands;

use App\DTO\SaveManagerDTO;
use App\Modules\AmoCRM\Api\User\UserApiInterface;
use App\Repositories\Manager\ManagerRepositoryInterface;
use App\Services\Syncer\Config\Config;
use Exception;
use Illuminate\Console\Command;

class SyncAmoManagersCommand extends Command
{
    protected $signature = 'amo:managers';
    protected $description = 'The command to synchronize amo managers';

    public function __construct(
        private readonly UserApiInterface           $userApi,
        private readonly ManagerRepositoryInterface $repo,

    )
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $managers = $this->userApi->get();
        foreach ($managers as $manager) {
            try {
                $this->repo->save(new SaveManagerDTO(
                    $manager['id'],
                    $manager['name'],
                    current($manager['groups'])['name'] ?? Config::DEFAULT_BRANCH_NAME
                ));
                $this->info('The manager was successfully synchronized.');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}

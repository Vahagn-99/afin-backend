<?php

namespace App\Console\Commands;

use App\DTO\RateDTO;
use App\Imports\ImportPipeline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportTestFileCommand extends Command
{
    protected $signature = 'import:test-file';

    protected $description = 'The command to import test file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
//        $file = Storage::disk('testing')->path('large_test_import_file.xlsx');
//        $currencies = new RateDTO(50, 30, 60);
//        Excel::queueImport(new ImportPipeline($currencies), $file)->onQueue('sync');
    }
}

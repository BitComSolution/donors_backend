<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Source;
use App\Services\SourceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Scheduled;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceService = new SourceService;
        $sourceService->dbSynchronize();
    }

}

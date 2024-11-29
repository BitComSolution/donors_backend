<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Source;
use App\Services\MSService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Scheduled;

class MS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ms';

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
        $MSService = new MSService;
        $MSService->send();
    }

}

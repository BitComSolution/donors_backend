<?php

namespace App\Console\Commands;

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
        $command = Scheduled::where('title', 'aist')->first();
        $date_next_start = Carbon::create($command['last_start'])->addHours($command['period_hours']);
        if ($date_next_start < Carbon::now()) {
            $MSService = new MSService;
            $MSService->send();
            $command['last_start']=Carbon::now();
            $command->save();
        }
    }

}

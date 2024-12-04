<?php

namespace App\Console\Commands;

use App\Services\SourceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Scheduled;

class Aist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aist';

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
            $sourceService = new SourceService;
            $sourceService->sendCommand(Carbon::now()->subDays(30)->toDateString(), Carbon::now()->toDateString());
            $command['last_start']=Carbon::now();
            $command->save();
        }
    }

}

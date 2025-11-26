<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Source;
use App\Services\SourceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Scheduled;

class Dump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dump';

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
        $service = new SourceService;

        $command = Scheduled::where('title', 'dump')->lockForUpdate()->first(); // защита от параллельных запусков

        if (!$command) {
            return false;
        }

        $nextStart = Carbon::parse($command->last_start)->addHours($command->period_hours);

        if ($nextStart->isPast()) {
            try {
                $command->update([
                    'run' => true,
                    'last_start' => now(),
                ]);

                $startDate = now()->subDays(7)->toDateString();
                $endDate = now()->toDateString();

                $service->sendCommand($startDate, $endDate);

            } catch (\Exception $e) {
                Logs::created(['name' => 'dump', 'error' => 1, 'file' =>  $e->getMessage()]);
                $command->update(['run' => false]);
            }
        }
    }

}

<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Scheduled;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:logs';

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
        $command = Scheduled::where('title', 'logs_clear')->first();
        $date_next_start = Carbon::create($command['last_start'])->addHours($command['period_hours']);
        if ($date_next_start > Carbon::now()) {//запуск скрипта по времени
            //взять данные из их приложения
            Source::all()->delete();//очистка доноров
            //загрузить новые данные
            //сделать логи
            try {
                Logs::create([
                    'title' => 'Create log ' . Carbon::now()->toDateString(),
                    'error' => false,
                    'file' => 'path']);
            } catch (\Exception $exception) {
                Logs::create([
                    'title' => 'Error log ' . Carbon::now()->toDateString(),
                    'error' => true,
                    'file' => 'path']);

            }
        }
    }

}

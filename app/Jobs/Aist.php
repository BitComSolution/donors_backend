<?php

namespace App\Jobs;

use App\Services\MSService;
use App\Services\SourceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class Aist implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sourceService = new SourceService;
        $sourceService->dbSynchronize();
    }
}

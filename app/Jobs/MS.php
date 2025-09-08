<?php

namespace App\Jobs;

use App\Services\MSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MS implements ShouldQueue
{
    use Queueable;

    public $ids;

    /**
     * Create a new job instance.
     */
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $MSService = new MSService;
        $MSService->send($this->ids);
    }
}

<?php

namespace ChemLab\Cron\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Cache;

class RunNextQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $worker = app('queue.worker');
        $worker->setCache(Cache::driver());
        $worker->runNextJob('database', 'default', new WorkerOptions());
    }
}

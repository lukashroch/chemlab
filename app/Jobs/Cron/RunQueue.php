<?php

namespace ChemLab\Jobs\Cron;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RunQueue implements ShouldQueue
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
        $count = DB::table('jobs')->count();
        if (!$count)
            return;

        $worker = app('queue.worker');
        $worker->setCache(Cache::driver());

        for ($i = 0; $i < $count; $i++) {
            $worker->runNextJob('database', 'default', new WorkerOptions());
            sleep(1);
        }
    }
}

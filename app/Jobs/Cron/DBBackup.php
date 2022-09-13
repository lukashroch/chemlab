<?php

namespace ChemLab\Jobs\Cron;

use Exception;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DBBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $dbConfig = config()->get('database.connections.mysql');
        $name = $dbConfig['database'] . '-' . date('Ymd-His', time()) . '.gz';

        $dump = new IMysqldump\Mysqldump(
            $dbConfig['driver'] . ':' . 'host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password'], [
                'compress' => 'Gzip',
                'add-drop-table' => true,
                'extended-insert' => true
            ]
        );
        $dump->start(storage_path("app/backups/{$name}"));

        try {
            $ftp = Storage::disk('ftp');
            $local = Storage::disk('local');
            $ftp->writeStream($name, $local->readStream("backups/{$name}"));
        } catch (\Exception $err) {
            logger()->error("Failed to upload database backup to FTP drive.");
            logger()->error($err->getMessage(), $err->getTrace());
        }
    }
}

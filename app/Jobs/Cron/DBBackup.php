<?php

namespace ChemLab\Cron\Jobs;

use Exception;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use VladimirYuldashev\Flysystem\CurlFtpAdapter as FtpAdapter;

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
        $ftpConfig = config()->get('filesystems.disks.ftp');
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

        $manager = new MountManager([
                'local' => new Filesystem(new LocalAdapter(storage_path("app/backups"))),
                'ftp' => new Filesystem(new FtpAdapter([
                    'host' => $ftpConfig['host'],
                    'username' => $ftpConfig['username'],
                    'password' => $ftpConfig['password'],
                    'root' => $ftpConfig['root']
                ]))
            ]
        );

        if ($manager->has("local://{$name}") && !$manager->has("ftp://{$name}")) {
            $manager->copy("local://{$name}", "ftp://{$name}");
        }
    }
}

<?php namespace ChemLab\Providers;

use Dropbox\Client as DropboxClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

class DropboxFilesystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('dropbox', function ($app, $config) {
            $client = new DropboxClient($config['accessToken'], $config['appName']);

            return new Filesystem(new DropboxAdapter($client));
        });
    }

    public function register()
    {
        $this->app->singleton('Dropbox', function () {
            $client = new DropboxClient(Config::get('filesystems.disks.dropbox.accessToken'), Config::get('filesystems.disks.dropbox.appName'));
            return new Filesystem(new DropboxAdapter($client));
        });
    }
}
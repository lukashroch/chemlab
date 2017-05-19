<?php

namespace ChemLab\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxFilesystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('dropbox', function ($app, $config) {
            $client = new DropboxClient($config['accessToken']);

            return new Filesystem(new DropboxAdapter($client));
        });
    }

    public function register()
    {
        $this->app->singleton('Dropbox', function () {
            $client = new DropboxClient(Config::get('filesystems.disks.dropbox.accessToken'));
            return new Filesystem(new DropboxAdapter($client));
        });
    }
}
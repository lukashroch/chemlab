<?php namespace ChemLab\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use ChemLab\Helpers\WebDAVClient;

class WebDAVFilesystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('webdav', function ($app, $config) {
            $client = new WebDAVClient($config);
            return new Filesystem(new WebDAVAdapter($client));
        });
    }

    public function register()
    {
        $this->app->singleton('WebDAV', function () {
            $client = new WebDAVClient(Config::get('filesystems.disks.webdav'));
            return new Filesystem(new WebDAVAdapter($client));
        });
    }
}
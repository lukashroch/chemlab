<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 'dropbox'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'dropbox' => [
            'driver' => 'dropbox',
            'appName' => env('DROPBOX_APP_NAME', ''),
            'appKey' => '',
            'appSecret' => '',
            'accessToken' => env('DROPBOX_APP_TOKEN', ''),
        ],

        'ftp' => [
            'driver' => 'ftp',
            'host' => env('FTP_HOST', ''),
            'username' => env('FTP_USERNAME', ''),
            'password' => env('FTP_PASSWORD', ''),
            'port' => env('FTP_PORT', 21),
            'root' => env('FTP_ROOT', ''),
            //'passive' => true,
            //'ssl' => true,
            //'timeout' => 30
        ],

        'webdav' => [
            'driver' => 'webdav',
            'baseUri' => env('WEBDAV_URL', ''),
            'userName' => env('WEBDAV_USERNAME', ''),
            'password' => env('WEBDAV_PASSWORD', ''),
            'proxy' => '',
            'authType' => '1',
            'encoding' => '',
            'certificate' => public_path() . '/cacert.pem'
        ]
    ]
];

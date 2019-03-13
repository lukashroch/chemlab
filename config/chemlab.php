<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ChemLab Specifics
    |--------------------------------------------------------------------------
    |
    */

    'name' => 'ChemLab',
    'abbreviation' => 'ChemLab',
    'keywords' => 'ChemLab',

    /*
    |--------------------------------------------------------------------------
    | Name of "Super Admin" role
    | This role will get assigned with all permissions and privileges
    | as they are created
    |--------------------------------------------------------------------------
    |
    */

    'superadmin' => 'superadmin',


    /*
    |--------------------------------------------------------------------------
    | Email settings
    | Default Email addresses
    |--------------------------------------------------------------------------
    |
    */

    'email' => [
        'contact' => 'chemlab@hroch.eu',
        'noreply' => 'noreply@hroch.eu',
        'delay' => 30
    ],

    /*
    |--------------------------------------------------------------------------
    | DB backup script
    |--------------------------------------------------------------------------
    |
    */

    'db_backup' => [
        'secret_key' => env('CHEMLAB_DBBACKUP_SECRETKEY', '')
    ]
];

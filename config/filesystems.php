<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            /*
             * Uploads live inside the document root on purpose.
             *
             * The conventional storage/app/public + `storage:link` pair needs a
             * symlink, and creating one on Windows requires either developer
             * mode or an elevated shell. When it silently fails you get exactly
             * what we had: files written to storage/app/public that nothing can
             * serve, so every upload looks broken in the library grid.
             *
             * Rooting the disk at public/era removes the symlink from the
             * picture entirely -- the web server reaches the files directly and
             * `storage:link` is no longer part of setup.
             */
            'root' => public_path('era'),
            /*
             * Root-relative on purpose.
             *
             * Every other asset on the public site is referenced as /site/...,
             * and media should behave the same. Tying these urls to APP_URL means
             * a mismatched host, port or scheme silently breaks every image the
             * CMS serves. Set FILESYSTEM_PUBLIC_URL only if the files really do
             * live on another domain, such as a CDN.
             */
            'url' => rtrim(env('FILESYSTEM_PUBLIC_URL', '/era'), '/'),
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    /*
     * Empty on purpose: the public disk lives at public/era, inside the
     * document root, so there is nothing left for `storage:link` to link.
     */
    'links' => [],

];

<?php

return  [
    'default' =>  env('DB_CONNECTION'),
    'connections' => [
        'pgsql' => [
            'driver'    => env('DB_CONNECTION'),
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD')
        ],
        'mongodb' => [
            'driver'   => 'mongodb',
            'dsn' => env('MONGO_DSN'),
            'database' => env('MONGO_DATABASE'),
        ],
    ],
    'migrations' => 'migrations',
    'redis' => [
        'client' => 'predis',
        'options' => [
            'cluster' => 'redis',
        ],
        'clusters' => [
            'default' => [
                [
                    'host' => env('REDIS_HOST'),
                    'password' => env('REDIS_PASSWORD'),
                    'port' => env('REDIS_PORT'),
                    'database' => env('REDIS_DB_DEFAULT'),
                ]
            ],
        ],
    ],
];

<?php

return [
    'modelNamespace' => '\\App\Model\\',
    'defaultDbDriver' => 'sqlite', // sqlite or sql
    'db' => [
        'dev' => [
            'driver' => 'mysql',
            'port' => '3306',
            'host' => 'localhost',
            'name' => 'dbname',
            'user' => 'dbuser',
            'password' => 'dbpassword'
        ],
        'prod' => [
            'driver' => 'mysql',
            'port' => '3306',
            'host' => 'localhost',
            'name' => 'dbname',
            'user' => 'dbuser',
            'password' => 'dbpassword'
        ],
        'sqlite' => [
            'path' => './db.sqlite'
        ]
    ]
];

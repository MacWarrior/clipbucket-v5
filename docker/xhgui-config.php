<?php

return [
    'profiler' => [
        'enable' => true,
        'generator' => 'uuidV4',
    ],
    'profiler.exclude' => [],
    'save.handler' => 'pdo',
    'save.handler.file' => [
        'filename' => '/tmp/xhgui/profiles/profiles.dat',
    ],
    'save.handler.pdo' => [
        'instance' => null,
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=xhgui;charset=utf8mb4',
        'user' => 'xhgui',
        'pass' => 'xhgui',
        'table' => 'results',
        'tableWatch' => 'watches',
        'initSchema' => true,
    ],
    'save.handler.mongodb' => [
        'hostname' => '127.0.0.1',
        'port' => '27017',
        'username' => null,
        'password' => null,
        'database' => 'xhprof',
        'options' => [
            'connector' => 'mongodb',
        ],
    ],
    'page.limit' => 25,
    'detail.count' => 6,
    'date.format' => 'Y-m-d H:i:s',
    'templates' => __DIR__ . '/../templates',
    'cache' => __DIR__ . '/../cache',
    'timezone' => 'Europe/Paris',
];

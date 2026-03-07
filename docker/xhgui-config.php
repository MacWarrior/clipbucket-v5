<?php

return [

    // On force PDO (MySQL)
    'save.handler' => 'pdo',

    'pdo' => [
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=xhgui;charset=utf8mb4',
        'user' => 'xhgui',
        'pass' => 'xhgui',

        // noms des tables attendus
        'table' => 'results',
        'tableWatch' => 'watches',
        'initSchema' => true
    ],

    'timezone' => 'Europe/Paris',
    'date.format' => 'Y-m-d H:i:s',
];
<?php
require_once "vendor/autoload.php";
require_once "config/container.php";

return [
    'paths' =>
        [
            'migrations' => 'db/migrations',
            'seeds' => 'db/seeds'
        ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'app',
        'app' => [
            'name' => $c->get("params")['phinx']['database'],
            'connection' => $c->get(PDO::class)
        ]
    ]
];
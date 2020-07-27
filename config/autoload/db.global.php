<?php
return [
    "pdo" => [
        "database" => "db/db.sqlite",
        "username" => "",
        "password" => "",
        "options"=> [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    "phinx" =>[
        "database" => "db/db.sqlite",
    ]
];
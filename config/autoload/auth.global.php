<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function (ContainerInterface $c) {
                return new BasicAuthMiddleware($c->get("params")['users']);
            }]
    ],
    'users' => ['admin' => 'admin'],
];
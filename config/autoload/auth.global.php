<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Container\Factories\Auth\BasicAuthMiddlewareFactory;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => BasicAuthMiddlewareFactory::class
        ]
    ],
    'users' => ['admin' => 'admin'],
];
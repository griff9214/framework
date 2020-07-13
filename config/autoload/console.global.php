<?php


use App\Console\ClearCacheCommand;
use Framework\Container\Factories\Console\ClearCacheCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            ClearCacheCommand::class => ClearCacheCommandFactory::class
        ]
    ],
    'cache_paths' => [
        'var/cache/twig',
        'var/cache/db',
    ],
];
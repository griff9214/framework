<?php


use App\Console\ClearCacheCommand;
use Framework\Console\ConsoleApplication;
use Framework\Container\Factories\Console\ClearCacheCommandFactory;
use Framework\Container\Factories\Console\ConsoleApplicationFactory;

return [
    'dependencies' => [
        'factories' => [
            ConsoleApplication::class => ConsoleApplicationFactory::class,
            ClearCacheCommand::class => ClearCacheCommandFactory::class
        ]
    ],
    'console_commands' =>[
        'cache:clear' => ClearCacheCommand::class,
        'cache:clear1' => ClearCacheCommand::class,
        'cache:clear2' => ClearCacheCommand::class,
        'cache:clear3' => ClearCacheCommand::class
    ],
    'cache_paths' => [
        'var/cache/twig',
        'var/cache/db',
    ],
];
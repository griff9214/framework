<?php


use App\Console\ClearCacheCommand;
use Framework\Container\Factories\Console\ClearCacheCommandFactory;
use Framework\Container\Factories\Console\ConsoleApplicationFactory;
use Symfony\Component\Console\Application;

return [
    'dependencies' => [
        'factories' => [
            Application::class => ConsoleApplicationFactory::class,
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
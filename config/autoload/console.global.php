<?php


use App\Console\ClearCacheCommand;
use App\Console\FixturesCommand;
use Framework\Container\Factories\Console\ClearCacheCommandFactory;
use Framework\Container\Factories\Console\ConsoleApplicationFactory;
use Framework\Container\Factories\Console\FixturesCommandFactory;
use Symfony\Component\Console\Application;

return [
    'dependencies' => [
        'factories' => [
            Application::class => ConsoleApplicationFactory::class,
            ClearCacheCommand::class => ClearCacheCommandFactory::class,
        ]
    ],
    'console_commands' =>[
        'cache:clear' => ClearCacheCommand::class,
        Doctrine\Migrations\Tools\Console\Command\VersionCommand::class,
        Doctrine\Migrations\Tools\Console\Command\DiffCommand::class,
        Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand::class,
        Doctrine\Migrations\Tools\Console\Command\ExecuteCommand::class,
        Doctrine\Migrations\Tools\Console\Command\GenerateCommand::class,
        Doctrine\Migrations\Tools\Console\Command\LatestCommand::class,
        Doctrine\Migrations\Tools\Console\Command\MigrateCommand::class,
        Doctrine\Migrations\Tools\Console\Command\RollupCommand::class,
        Doctrine\Migrations\Tools\Console\Command\StatusCommand::class,
        Doctrine\Migrations\Tools\Console\Command\UpToDateCommand::class,
        Doctrine\Migrations\Tools\Console\Command\VersionCommand::class,

    ],
    'cache_paths' => [
        'var/cache/twig',
        'var/cache/db',
    ],
];
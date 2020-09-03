<?php

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Framework\Container\Factories\db\PDOFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

return [
    'dependencies' => [
        'factories' => [
            EntityManagerInterface::class => EntityManagerFactory::class,
            PDO::class => PDOFactory::class,
        ],
    ],
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'filesystem',
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'hydration_cache' => 'filesystem',
            ]
        ],
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'sqlite::db/db.sqlite',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities'
                ],
            ],
            'entities' => [
                'class' => AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => ['App/Entity']
            ],
        ],
        'cache' => [
            'filesystem' => [
                'class' => FilesystemCache::class,
                'directory' => 'var/cache/DoctrineCache',
            ],
        ],
    ],
    'fixtures_path' => 'db/fixtures'
];
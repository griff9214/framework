#!/usr/bin/env php
<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require "vendor/autoload.php";
require_once "config/container.php";

/**
 * @var Application $cli
 */
$cli = $c->get(Application::class);

/**
 * @var EntityManagerInterface $em
 */
$em = $c->get(EntityManagerInterface::class);
$connection = $em->getConnection();
$configuration = new Configuration($connection);
$configuration->setMigrationsDirectory('db/migrations');
$configuration->setMigrationsNamespace('Migration');

$cli->getHelperSet()->set(new EntityManagerHelper($c->get(EntityManagerInterface::class)), 'em');
$cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');
ConsoleRunner::addCommands($cli);

$cli->run();
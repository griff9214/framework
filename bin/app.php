#!/usr/bin/env php
<?php

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

$cli->getHelperSet()->set(new EntityManagerHelper($c->get(EntityManagerInterface::class)), 'em');
ConsoleRunner::addCommands($cli);

$cli->run();
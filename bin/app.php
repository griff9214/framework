#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require "vendor/autoload.php";
require_once "config/container.php";

/**
 * @var Application $cli
 */
$cli = $c->get(Application::class);
$cli->run();
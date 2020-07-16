#!/usr/bin/env php
<?php

use App\Console\ClearCacheCommand;
use Framework\Console\ConsoleApplication;
use Framework\Console\ConsoleInput;
use Framework\Console\ConsoleOutput;

chdir(dirname(__DIR__));
require "vendor/autoload.php";
require_once "config/container.php";

/**
 * @var ConsoleApplication $cli
 */
$cli = $c->get(ConsoleApplication::class);
$cli->run(new ConsoleInput($argv), new ConsoleOutput());
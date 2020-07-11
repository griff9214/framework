#!/usr/bin/env php
<?php

use App\Console\ClearCacheCommand;
use Framework\Console\ConsoleInput;

chdir(dirname(__DIR__));
require "vendor/autoload.php";
require_once "config/container.php";

$command = $c->get(ClearCacheCommand::class);
$command->execute(new ConsoleInput($argv));

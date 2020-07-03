<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . "/autoload/{{,*.}global,{,*.}local}.php"),
], "var/cache/CachedAppConfig.php");
return $aggregator->getMergedConfig();
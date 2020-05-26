<?php

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;

$c = new ServiceManager([
    'services'           => [
        'params'=> require_once "config/parameters.php"
    ],
    'factories'          => require_once "config/dependencies.php",
    'abstract_factories' => [
        ReflectionBasedAbstractFactory::class
    ],
]);
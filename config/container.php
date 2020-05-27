<?php

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;

$config = require_once "config/config.php";
$c = new ServiceManager($config['dependencies']);
$c->setService('params',$config);
$c->addAbstractFactory(ReflectionBasedAbstractFactory::class);
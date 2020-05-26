<?php


use Framework\Http\Application;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;


chdir(dirname(__DIR__));

require_once "vendor/autoload.php";
require_once "config/container.php";

$app = $c->get(Application::class);
require_once "config/pipeline.php";
require_once "config/routes.php";

$request = ServerRequestFactory::fromGlobals();
$responsePrototype = $app->run($request);

$emitter = new SapiEmitter();
$emitter->emit($responsePrototype);

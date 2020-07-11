<?php


namespace Framework\Container\Factories\Auth;


use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;

class BasicAuthMiddlewareFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return new BasicAuthMiddleware($c->get("params")['users']);
    }
}
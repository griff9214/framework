<?php


namespace App\Http\Middleware;


use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeveloperMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $next($request);
        return $response->withHeader("X-developer", "griff");
    }

}
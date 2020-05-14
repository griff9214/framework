<?php


namespace App\Http\Middleware;


use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Router\RouteInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class BlogUnavailable
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /**
         * @var RouteInterface $route
         */
        $route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM);
        if ($route->getName() === "blog-iindex"){
            return new HtmlResponse("Blog is not available at this moment", 403);
        }
        return $next($request);
    }

}
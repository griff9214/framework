<?php


namespace App\Http\Middleware;


use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Router\RouteInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogUnavailable implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var RouteInterface $route
         */
        if (!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            return new HtmlResponse("Blog is not available at this moment", 403);
        }
        return $handler->handle($request);
    }

}
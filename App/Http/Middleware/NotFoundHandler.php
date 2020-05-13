<?php


namespace App\Http\Middleware;


use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;

class NotFoundHandler
{
    public function __invoke(RequestInterface $request)
    {
        return new HtmlResponse("Page {$request->getUri()->getPath()} not found", 404);
    }

}
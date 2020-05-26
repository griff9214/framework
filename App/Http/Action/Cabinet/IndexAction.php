<?php


namespace App\Http\Action\Cabinet;

use App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse("Cabinet index page. Hello " . $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE));
    }


}
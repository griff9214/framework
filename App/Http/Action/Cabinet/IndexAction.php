<?php


namespace App\Http\Action\Cabinet;

use App\Http\Middleware\AuthMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse("Cabinet index page. Hello " . $request->getAttribute(AuthMiddleware::ATTRIBUTE));
    }


}
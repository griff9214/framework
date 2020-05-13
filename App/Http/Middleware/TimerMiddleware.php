<?php


namespace App\Http\Middleware;


use Psr\Http\Message\ServerRequestInterface;

class TimerMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $nextAction)
    {
        $start = microtime(true);

        $response = $nextAction($request);

        $stop = microtime(true);
        return $response->withHeader("Timer", $stop - $start);
    }
}
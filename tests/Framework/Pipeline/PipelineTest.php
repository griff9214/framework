<?php


namespace Framework\Pipeline;


use Framework\Http\Pipeline\Pipeline;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PipelineTest extends TestCase
{
    public function testPipe()
    {
        $pipeline = new Pipeline(new Last());
        $pipeline->pipe(new MiddleWare1());
        $pipeline->pipe(new MiddleWare2());
        $response = $pipeline->run(new ServerRequest());

        self::assertJsonStringEqualsJsonString($response->getBody()->getContents(), json_encode(["MiddleWare1"=> 1, "MiddleWare2"=> 2]));

    }

}

class MiddleWare1
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return $next($request->withAttribute("MiddleWare1", 1));
    }
}

class MiddleWare2
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return $next($request->withAttribute("MiddleWare2", 2));
    }
}

class Last
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new JsonResponse($request->getAttributes());
    }
}
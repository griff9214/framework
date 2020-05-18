<?php


namespace Framework\Pipeline;


use Framework\Http\Pipeline\Pipeline;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PipelineTest extends TestCase
{
    public function testPipe()
    {
        $pipeline = new Pipeline();
        $pipeline->pipe(
            function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
                return (new MiddleWare1())($request, $next);
            }
        );
        $pipeline->pipe(
            function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
                return (new MiddleWare2())($request, $next);
            }
        );
        $request = new ServerRequest();
        $response1 = new Response\EmptyResponse();
        $response = $pipeline($request, $response1, new Last());

        self::assertJsonStringEqualsJsonString($response->getBody()->getContents(), json_encode(["MiddleWare1" => 1, "MiddleWare2" => 2]));

    }

}

class MiddleWare1
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        return $next($request->withAttribute("MiddleWare1", 1));
    }
}

class MiddleWare2
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
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
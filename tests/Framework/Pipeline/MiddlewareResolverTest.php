<?php


namespace Framework\Pipeline;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Pipeline\Resolver;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareResolverTest extends TestCase
{
    /**
     * @dataProvider getHandlers
     * @param $handler
     */
    public function testDirect($handler)
    {
        $middleware = MiddlewareResolver::resolve($handler);
        $response = $middleware(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new Response(),
            new NotFoundMiddleware()
        );
        self::assertEquals([$value], $response->getHeader("X-Header"));
    }

    /**
     * @dataProvider getHandlers
     * @param $handler
     */
    public function testNext($handler)
    {
        $middleware = MiddlewareResolver::resolve($handler);
        $response = $middleware(
            (new ServerRequest())->withAttribute('next', true),
            new Response(),
            new NotFoundMiddleware()
        );
        self::assertEquals(404, $response->getStatusCode());
    }

    public function testArray()
    {
        $array = [
            new DummyMiddleware(),
            new CallableMiddleware(),
        ];
        $middleware = MiddlewareResolver::resolve($array);
        $response = $middleware(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new Response(),
            new NotFoundMiddleware()
        );
        self::assertEquals(['dummy'], $response->getHeader('X-Dummy'));
        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    public function getHandlers(): array
    {
        return [
            "Callable callback" => [function (ServerRequestInterface $request, $next) {
                if ($request->getAttribute('next')) {
                    return $next($request);
                }
                return (new Response\HtmlResponse(''))
                    ->withHeader("X-Header", $request->getAttribute('attribute'));
            }],
            "Callable class" => [CallableMiddleware::class],
            "Callable object" => [new CallableMiddleware()],
            "Doublepass Callback" => [function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
                if ($request->getAttribute('next')) {
                    return $next($request);
                }
                return $response
                    ->withHeader("X-Header", $request->getAttribute('attribute'));
            }],
            "Doublepass class" => [DoublePassMiddleware::class],
            "Doublepass object" => [new DoublePassMiddleware()],
            "PSR-15 class" => [PsrMiddleware::class],
            "PSR-15 object" => [new PsrMiddleware()],
        ];
    }
}

class CallableMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        if ($request->getAttribute('next')) {
            return $next($request);
        }
        return (new Response\HtmlResponse(''))
            ->withHeader("X-Header", $request->getAttribute('attribute'));
    }
}

class DoublePassMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($request->getAttribute('next')) {
            return $next($request);
        }
        return $response
            ->withHeader("X-Header", $request->getAttribute('attribute'));
    }
}

class PsrMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $handler->handle($request);
        }
        return (new Response\HtmlResponse(''))
            ->withHeader("X-Header", $request->getAttribute('attribute'));

    }
}

class NotFoundMiddleware
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new Response\EmptyResponse(404);
    }
}

class DummyMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        return $next($request)
            ->withHeader('X-Dummy', 'dummy');
    }
}
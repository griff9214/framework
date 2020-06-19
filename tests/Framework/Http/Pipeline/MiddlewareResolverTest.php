<?php


namespace Framework\Pipeline;


use Tests\Framework\Http\DummyContainer;
use Framework\Http\Pipeline\MiddlewareResolver;
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
        $resolver = new MiddlewareResolver(new DummyContainer(), new Response());
        $middleware = $resolver->resolve($handler);
        $response = $middleware->process(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new NotFoundHandler()
        );
        self::assertEquals([$value], $response->getHeader("X-Header"));
    }

    /**
     * @dataProvider getHandlers
     * @param $handler
     */
    public function testNext($handler)
    {
        $resolver = new MiddlewareResolver(new DummyContainer(), new Response());
        $middleware = $resolver->resolve($handler);
        $response = $middleware->process(
            (new ServerRequest())->withAttribute('next', true),
            new NotFoundHandler()
        );
        self::assertEquals(404, $response->getStatusCode());
    }

    public function testArray()
    {
        $array = [
            new DummyMiddleware(),
            new CallableMiddleware(),
        ];
        $resolver = new MiddlewareResolver(new DummyContainer(), new Response());
        $middleware = $resolver->resolve($array);
        $response = $middleware->process(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new NotFoundHandler()
        );
        self::assertEquals(['dummy'], $response->getHeader('X-Dummy'));
        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    public function getHandlers(): array
    {
        return [
            "Callable callback" => [function (ServerRequestInterface $request, callable $next) {
                if ($request->getAttribute('next')) {
                    return $next($request);
                }
                return (new Response\HtmlResponse(''))
                    ->withHeader("X-Header", $request->getAttribute('attribute'));
            }],
            "Callable class" => [CallableMiddleware::class],
            "Callable object" => [new CallableMiddleware()],
            "Doublepass Callback" => [function (ServerRequestInterface $request, ResponseInterface $response, callable $handler) {
                if ($request->getAttribute('next')) {
                    return $handler($request, $response);
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
            return $next($request, $response);
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

class NotFoundHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response\EmptyResponse(404);
    }
}

class DummyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request)
            ->withHeader('X-Dummy', 'dummy');
    }
}
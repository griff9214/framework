<?php


use App\Http\Action\HelloAction;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\RouteDataObject;
use Framework\Http\Router\RouteInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class HelloActionTest extends TestCase
{
    private TemplateRenderer $renderer;
    private $requestVasya;
    private ServerRequest $requestGuest;


    public function setUp(): void
    {
        $this->renderer = new TemplateRenderer("templates", new DummyRouter());
        $this->requestVasya = (new ServerRequest())->withMethod("get")->withQueryParams(["name"=>"Vasya"]);
        $this->requestGuest = (new ServerRequest());
    }

    public function testWithName()
    {
        $action = new HelloAction($this->renderer);
        $resp = $action->handle($this->requestVasya);

        self::assertEquals(200, $resp->getStatusCode());
        self::assertStringContainsString("Hello, Vasya", $resp->getBody()->getContents());
    }
    public function testEmpty()
    {
        $action = new HelloAction($this->renderer);
        $resp = $action->handle($this->requestGuest);

        self::assertEquals(200, $resp->getStatusCode());
        self::assertStringContainsString("Hello, Guest", $resp->getBody()->getContents());
    }
}
class DummyRouter implements RouterInterface{

    public function match(ServerRequestInterface &$request): RouteInterface
    {
        // TODO: Implement match() method.
    }

    public function generate(string $name, array $params = []): ?string
    {
        // TODO: Implement generate() method.
    }

    public function bindParams(ServerRequestInterface $request, array $matches): ServerRequestInterface
    {
        // TODO: Implement bindParams() method.
    }

    public function addRoute(RouteDataObject $routeData)
    {
        // TODO: Implement addRoute() method.
    }
}
<?php


use App\Http\Action\HelloAction;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class HelloActionTest extends TestCase
{
    private TemplateRenderer $renderer;
    private $requestVasya;
    private ServerRequest $requestGuest;


    public function setUp(): void
    {
        $this->renderer = new TemplateRenderer("templates");
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
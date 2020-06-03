<?php


namespace App\Http\Action\Blog;


use App\ReadModel\PostReadModel;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    private PostReadModel $postRepository;
    private TemplateRenderer $renderer;

    public function __construct(PostReadModel $postRepository, TemplateRenderer $renderer)
    {
        $this->postRepository = $postRepository;
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $posts = $this->postRepository->getAll();

        return new HtmlResponse($this->renderer->render("app/blog/index", ["posts" => $posts]));
    }

}
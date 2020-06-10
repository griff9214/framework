<?php


namespace App\Http\Action\Blog;

use App\ReadModel\PostReadModel;
use Framework\Template\php\PhpRenderer;
use Framework\Template\php\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PostAction implements MiddlewareInterface
{
    private PostReadModel $postRepository;
    private TemplateRenderer $renderer;

    public function __construct(PostReadModel $postRepository, TemplateRenderer $renderer)
    {
        $this->postRepository = $postRepository;
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //$request->getAttribute("slug")
        if(!($post = $this->postRepository->findPostById($request->getAttribute("id")))){
            return $handler->handle($request);
        }

        return new HtmlResponse($this->renderer->render("app/blog/post", ["post" => $post]));
    }
}
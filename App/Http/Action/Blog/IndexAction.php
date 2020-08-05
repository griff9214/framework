<?php

namespace App\Http\Action\Blog;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadModel;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    public const PER_PAGE_LIMIT = 10;
    private PostReadModel $postRepository;
    private TemplateRenderer $renderer;

    public function __construct(PostReadModel $postRepository, TemplateRenderer $renderer)
    {
        $this->postRepository = $postRepository;
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pager = new Pagination(
            $request->getAttribute('pageNumber') ?? 1,
            $this->postRepository->getPostsCount(),
            self::PER_PAGE_LIMIT
        );

        $posts = $this->postRepository->getAll($pager->getOffset(), self::PER_PAGE_LIMIT);

        return new HtmlResponse($this->renderer->render("app/blog/index", [
            "posts" => $posts,
            'pager' => $pager,
        ]));
    }
}

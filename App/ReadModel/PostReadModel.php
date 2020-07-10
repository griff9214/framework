<?php

namespace App\ReadModel;

use App\ReadModel\View\PostView;
use DateTimeImmutable;

use function array_reverse;

class PostReadModel
{
    private array $posts = [];

    public function __construct()
    {
        $this->posts = [
            new PostView(1, new DateTimeImmutable("2020-06-01"), "Title of post 1", "Content of post 1"),
            new PostView(2, new DateTimeImmutable("2020-06-03"), "Title of post 2", "Content of post 2"),
        ];
    }

    /**
     * @return PostView[]
     */
    public function getAll(): array
    {
        return array_reverse($this->posts);
    }

    public function findPostById(int $id): ?PostView
    {
        foreach ($this->posts as $post) {
            if ($post->id === $id) {
                return $post;
            }
        }
        return null;
    }
}

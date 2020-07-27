<?php

namespace App\ReadModel;

use App\ReadModel\View\PostView;
use DateTimeImmutable;

use PDO;
use function array_reverse;

class PostReadModel
{
    private array $posts = [];
    /**
     * @var PDO
     */
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->posts = [
            new PostView(1, new DateTimeImmutable("2020-06-01"), "Title of post 1", "Content of post 1"),
            new PostView(2, new DateTimeImmutable("2020-06-03"), "Title of post 2", "Content of post 2"),
        ];
        $this->pdo = $pdo;
    }

    /**
     * @return PostView[]
     */
    public function getAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM posts order by id desc");
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($row) {
            return $this->hydratePost($row);
        }, $rows);
    }

    protected function hydratePost(array $row): PostView
    {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = new DateTimeImmutable($row['date']);
        return new PostView($id, $date, $title, $content);
    }

    public function findPostById(int $id): ?PostView
    {
        $query = $this->pdo->prepare("SELECT * FROM posts where id = :id");
        $query->bindParam("id", $id);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $this->hydratePost($row);
    }
}

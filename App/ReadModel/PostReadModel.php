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
        $this->pdo = $pdo;
    }

    /**
     * @return PostView[]
     */
    public function getAll(int $offset, int $limit): array
    {
        $query = $this->pdo->prepare("SELECT * FROM posts ORDER BY date LIMIT :limit OFFSET :offset");
        $query->bindParam('offset', $offset, PDO::PARAM_INT);
        $query->bindParam('limit', $limit, PDO::PARAM_INT);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($row) {
            return $this->hydratePost($row);
        }, $rows);
    }

    public function getPostsCount(): int
    {
        $stmt = $this->pdo->query("Select count(id) from posts");
        return $stmt->fetch(PDO::FETCH_NUM)[0];
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

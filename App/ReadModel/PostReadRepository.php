<?php

namespace App\ReadModel;

use DateTimeImmutable;
use PDO;

class PostReadRepository
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

    public function getAll(int $offset, int $limit): array
    {
        $query = $this->pdo->prepare(
            "SELECT p.*,(SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) comments_count FROM posts p ORDER BY p.create_date DESC LIMIT :limit OFFSET :offset");
        $query->bindParam('offset', $offset, PDO::PARAM_INT);
        $query->bindParam('limit', $limit, PDO::PARAM_INT);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($row) {
            return $this->hydratePostList($row);
        }, $rows);
    }

    public function getPostsCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(id) FROM posts");
        return $stmt->fetch(PDO::FETCH_NUM)[0];
    }

    public function findPostById(int $id): ?array
    {
        $query = $this->pdo->prepare("
                SELECT p.*,(SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) comments_count FROM posts p where id = :id
                ");
        $query->bindParam("id", $id);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) return null;
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE post_id=:post_id order by id ASC");
        $query->bindParam("post_id", $id, PDO::PARAM_INT);
        $query->execute();
        $row['comments'] = array_map([$this, 'hydrateComment'], $query->fetchAll(PDO::FETCH_ASSOC));
        return $this->hydratePostShow($row);
    }

    protected function hydratePostShow(array $row): array
    {
        return [
            'id' => $row['id'],
            'create_date' => new DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'content_short' => $row['content_short'],
            'content_full' => $row['content_full'],
            'meta' => [
                'meta_title' => $row['meta_title'],
                'meta_keywords' => $row['meta_keywords'],
                'meta_description' => $row['meta_description'],
            ],
            'update_date' => $row['update_date'],
            'comments_count' => $row['comments_count'],
            'comments' => $row['comments'],
        ];
    }

    protected function hydratePostList(array $row): array
    {
        return [
            'id' => $row['id'],
            'create_date' => new DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'content_short' => $row['content_short'],
            'comments_count' => $row['comments_count'],
        ];
    }

    protected function hydrateComment(array $row): array
    {
        return [
            'id' => $row['id'],
            'date' => new DateTimeImmutable($row['date']),
            'author' => $row['author'],
            'text' => $row['text'],
        ];
    }
}

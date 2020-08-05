<?php


namespace App\ReadModel;


class Pagination
{
    private int $currentPage;
    private int $postsCount;
    private int $limitPerPage;

    public function __construct(int $currentPage, int $postsCount, int $limitPerPage)
    {
        $this->currentPage = $currentPage;
        $this->postsCount = $postsCount;
        $this->limitPerPage = $limitPerPage;
    }

    public function getPagesCount()
    {
        return ($this->postsCount / $this->limitPerPage);
    }

    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->limitPerPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPostsCount(): int
    {
        return $this->postsCount;
    }

    public function getLimitPerPage(): int
    {
        return $this->limitPerPage;
    }


}
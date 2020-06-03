<?php


namespace App\ReadModel\View;


class PostView
{
    public int $id;
    public \DateTimeImmutable $date;
    public string $title;
    public string $content;

    public function __construct(int $id, \DateTimeImmutable $date, string $title, string $content)
    {
        $this->id = $id;
        $this->date = $date;
        $this->title = $title;
        $this->content = $content;
    }
}
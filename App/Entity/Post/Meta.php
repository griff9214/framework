<?php


namespace App\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Meta
 * @package App\Entity\Post
 * @ORM\Embeddable()
 */
class Meta
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $title;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $keywords;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $description;

    public function __construct(string $title, string $keywords, string $description)
    {
        $this->title = $title;
        $this->keywords = $keywords;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}
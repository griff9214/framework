<?php


namespace App\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Content
 * @package App\Entity\Post
 * @ORM\Embeddable()
 */
class Content
{
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $short;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $full;

    public function __construct(string $short, string $full)
    {
        $this->short = $short;
        $this->full = $full;
    }

    /**
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @return string
     */
    public function getFull(): string
    {
        return $this->full;
    }

}
<?php


namespace App\Entity\Post;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Stdlib\Exception\DomainException;
use \DateTimeImmutable;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="create_date")
     */
    private DateTimeImmutable $createDate;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="update_date", nullable=true)
     */
    private DateTimeImmutable $updateDate;
    /**
     * @ORM\Column(type="string")
     */
    private string $title;
    /**
     * @var Content
     * @ORM\Embedded(class="Content")
     */
    private Content $content;
    /**
     * @var Meta
     * @ORM\Embedded(class="Meta")
     */
    private Meta $meta;
    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private Collection $comments;

    public function __construct(DateTimeImmutable $date, string $title, Content $content, Meta $meta)
    {
        $this->createDate = $date;
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->comments = new ArrayCollection();
    }

    public function edit(string $title, Content $content, Meta $meta):void
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->updateDate = new DateTimeImmutable(true);
    }

    public function addComment(DateTimeImmutable $date, string $author, string $content):void
    {
        $this->comments->add(new Comment($this, $date, $author, $content));
    }

    public function removeComment(int $id)
    {
        foreach ($this->comments as $comment) {
            if ($comment->getId === $id){
                $this->comments->removeElement($comment);
            }
        }
        throw new DomainException("Comment not found");
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreateDate(): DateTimeImmutable
    {
        return $this->createDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdateDate(): DateTimeImmutable
    {
        return $this->updateDate;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @return Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return Comment[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }
    
}
<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="articles")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="RecruitmentApp\Domain\User")
     * @ORM\JoinColumn(onDelete="cascade", nullable=false)
     */
    private User $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    public function __construct(User $author, string $title, string $content)
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
    }

}

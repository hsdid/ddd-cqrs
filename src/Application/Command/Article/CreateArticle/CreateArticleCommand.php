<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Command\Article\CreateArticle;

class CreateArticleCommand
{
    /**
     * @var int
     */
    private int $authorId;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $content;

    /**
     * @param int $authorId
     * @param string $title
     * @param string $content
     */
    public function __construct(
        int $authorId,
        string $title,
        string $content
    ) {
        $this->authorId = $authorId;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
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
    public function getContent(): string
    {
        return $this->content;
    }
}

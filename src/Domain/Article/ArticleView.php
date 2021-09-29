<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain\Article;

use RecruitmentApp\Domain\User\UserView;

class ArticleView
{
    /**
     * @var UserView
     */
    public UserView $author;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $content;

    /**
     * @param UserView $author
     * @param string $title
     * @param string $content
     */
    public function __construct(UserView $author, string $title, string $content)
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
    }
}

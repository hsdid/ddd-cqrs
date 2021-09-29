<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain\Article;

use RecruitmentApp\Domain\Article;

interface ArticleRepositoryInterface
{
    public function find(int $id): ?Article;

    public function add(Article $article): void;

    public function remove(Article $article): void;
}

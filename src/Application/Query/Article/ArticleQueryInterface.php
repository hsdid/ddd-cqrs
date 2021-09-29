<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Query\Article;

use RecruitmentApp\Domain\Article\ArticleView;

interface ArticleQueryInterface
{
    public function getById(int $id): ?ArticleView;

    public function getByPage(int $itemsCount, int $pageNr): array;

    public function getAll();
}

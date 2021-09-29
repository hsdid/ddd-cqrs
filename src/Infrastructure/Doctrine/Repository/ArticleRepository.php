<?php

namespace RecruitmentApp\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use RecruitmentApp\Domain\Article;
use RecruitmentApp\Domain\Article\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article
    {
        return $this->em->find(Article::class, $id);
    }

    /**
     * @param Article $article
     */
    public function add(Article $article): void
    {
        $this->em->persist($article);
        $this->em->flush();
    }

    /**
     * @param Article $article
     */
    public function remove(Article $article): void
    {
        $this->em->remove($article);
        $this->em->flush();
    }
}
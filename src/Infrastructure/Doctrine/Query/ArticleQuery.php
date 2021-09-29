<?php

namespace RecruitmentApp\Infrastructure\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RecruitmentApp\Application\Query\Article\ArticleQueryInterface;
use RecruitmentApp\Domain\Article\ArticleView;
use RecruitmentApp\Domain\User\UserView;
use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\ApiKey;

class ArticleQuery implements ArticleQueryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Email\Exception\InvalidEmail
     * @throws Exception
     */
    public function getById(int $id): ?ArticleView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('a.id', 'a.title', 'a.content', 'u.id as user_id' , 'u.email', 'u.api_key')
            ->from(' articles', 'a')
            ->innerJoin('a', 'users', 'u', 'a.author_id = u.id')
            ->where('a.id = :id')
            ->setParameter('id', $id);

        $articleData =  $this->connection
            ->fetchAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new ArticleView(
            new UserView(
                $articleData['user_id'],
                new Email($articleData['email']),
                new ApiKey($articleData['api_key'])
            ),
            $articleData['title'],
            $articleData['content']
        );
    }

    /**
     * @throws Email\Exception\InvalidEmail
     * @throws Exception
     */
    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('a.id', 'a.title', 'a.content', 'u.id as user_id' , 'u.email', 'u.api_key')
            ->from(' articles', 'a')
            ->innerJoin('a', 'users', 'u', 'a.author_id = u.id');

        $articlesData =  $this->connection
            ->fetchAllAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function(array $articleData) {
            return new ArticleView(
                new UserView(
                    $articleData['user_id'],
                    new Email($articleData['email']),
                    new ApiKey($articleData['api_key'])
                ),
                $articleData['title'],
                $articleData['content']
            );
        }, $articlesData);
    }

    /**
     * @throws Email\Exception\InvalidEmail
     * @throws Exception
     */
    public function getByPage(int $itemsCount, int $pageNr): array
    {
        $offset = ($pageNr-1) * $itemsCount;

        $queryBuilderAllRecords = $this->connection->createQueryBuilder();
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilderAllRecords
            ->select('count(a.id) as numberOfRecords')
            ->from('articles', 'a')
        ;

        $allRecords =  $this->connection
            ->fetchAssociative($queryBuilderAllRecords->getSQL(), $queryBuilderAllRecords->getParameters());

        $queryBuilder
            ->select('a.id', 'a.title', 'a.content', 'u.id as user_id' , 'u.email', 'u.api_key')
            ->from('articles', 'a')
            ->innerJoin('a', 'users', 'u', 'a.author_id = u.id')
            ->setFirstResult($offset)
            ->setMaxResults($itemsCount)
        ;

        $articlesData =  $this->connection
            ->fetchAllAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $totalNumberOfPages = ceil((int)$allRecords['numberOfRecords'] / $itemsCount);

        $articles = array_map(function(array $articleData) {
            return new ArticleView(
                new UserView(
                    $articleData['user_id'],
                    new Email($articleData['email']),
                    new ApiKey($articleData['api_key'])
                ),
                $articleData['title'],
                $articleData['content']
            );
        }, $articlesData);

        return ['articles' => $articles, 'totalNumberOfPages' => $totalNumberOfPages];
    }
}

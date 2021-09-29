<?php

namespace RecruitmentApp\Infrastructure\Doctrine\Query;

use Doctrine\DBAL\Connection;
use RecruitmentApp\Application\Query\User\UserQueryInterface;
use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\ApiKey;
use RecruitmentApp\Domain\User\UserView;


class UserQuery implements UserQueryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): UserView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('u.id', 'u.email', 'u.api_key')
            ->from('users','u')
            ->where('u.id = :id')
            ->setParameter('id', $id);

        $userData = $this->connection->fetchAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new UserView($userData['id'], new Email($userData['email']), new ApiKey($userData['api_key']));
    }

    /**
     * @throws Email\Exception\InvalidEmail
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByEmail(Email $email): UserView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('u.id','u.email', 'u.api_key')
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        $userData = $this->connection->fetchAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new UserView($userData['id'], new Email($userData['email']), new ApiKey($userData['api_key']));
    }

    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('u.id', 'u.email', 'u.api_key')
            ->from('users', 'u');

        $usersData =  $this->connection->fetchAllAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function(array $userData) {
            return new UserView(
                $userData['id'],
                new Email($userData['email']),
                new ApiKey($userData['api_key'])
            );
        }, $usersData);
    }
}

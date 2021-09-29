<?php

namespace RecruitmentApp\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use RecruitmentApp\Domain\User;
use RecruitmentApp\Domain\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $_em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->_em = $em;
    }

    /**
     * @param $id
     * @return User|null
     */
    public function find($id): ?User
    {
        return $this->_em->find(User::class, $id);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister(User::class);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param User $user
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}

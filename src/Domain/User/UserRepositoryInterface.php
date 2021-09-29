<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain\User;

use RecruitmentApp\Domain\User;

interface UserRepositoryInterface
{
    public function find($id): ?User;

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    public function add(User $user): void;

    public function remove(User $user): void;

}

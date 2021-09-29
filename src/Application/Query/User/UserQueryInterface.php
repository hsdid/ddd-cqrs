<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Query\User;

use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\UserView;

interface UserQueryInterface
{
    public function findByEmail(Email $email): UserView;

    public function findById(int $id): UserView;

    public function getAll();
}
<?php

namespace RecruitmentApp\Application\Command\User\DeleteUser;

final class DeleteUserCommand
{
    /**
     * @var int
     */
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

}
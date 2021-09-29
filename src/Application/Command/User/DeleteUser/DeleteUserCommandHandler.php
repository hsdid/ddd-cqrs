<?php

namespace RecruitmentApp\Application\Command\User\DeleteUser;

use RecruitmentApp\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteUserCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserCommand $command
     */
    public function __invoke(DeleteUserCommand $command)
    {
        $user = $this->userRepository->find($command->getUserId());

        $this->userRepository->remove($user);
    }
}

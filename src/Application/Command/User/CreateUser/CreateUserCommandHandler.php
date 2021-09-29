<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Command\User\CreateUser;

use RecruitmentApp\Domain\User;
use RecruitmentApp\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateUserCommandHandler implements MessageHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateUserCommand $command
     */
    public function __invoke(CreateUserCommand $command)
    {
        $user = new User(
            $command->getEmail(),
            $command->getApiKey()
        );
        $this->userRepository->add($user);
    }
}

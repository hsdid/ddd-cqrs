<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use RecruitmentApp\Application\Command\User\CreateUser\CreateUserCommand;
use RecruitmentApp\Application\Command\User\DeleteUser\DeleteUserCommand;
use RecruitmentApp\Application\Query\User\UserQueryInterface;
use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\ApiKey;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var UserQueryInterface
     */
    private UserQueryInterface $userQuery;

    /**
     * @param MessageBusInterface $messageBus
     * @param UserQueryInterface $userQuery
     */
    public function __construct(
        MessageBusInterface $messageBus,
        UserQueryInterface $userQuery,
    ) {
        $this->messageBus = $messageBus;
        $this->userQuery = $userQuery;
    }

    #[Route(path: '/users', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $command = new CreateUserCommand(
            new Email($request->get('email')),
            ApiKey::generate()
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    #[Route(path: '/users/{id}', name: 'delete', methods: ['DELETE'])]
    public function  delete(int $id): JsonResponse
    {
        $command = new DeleteUserCommand($id);

        $this->messageBus->dispatch($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    #[Route(path: '/users/{id}', name: 'get_by_id', methods: ['GET'])]
    public function  getById(int $id): JsonResponse
    {
        $user = $this->userQuery->findById($id);

        return new JsonResponse(['user' => $user], Response::HTTP_OK);
    }

    #[Route(path: '/users/', name: 'get_users', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $users = $this->userQuery->getAll();

        return new JsonResponse(['users' => $users], Response::HTTP_OK);
    }
}

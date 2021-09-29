<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Controller;

use RecruitmentApp\Application\Command\Article\CreateArticle\CreateArticleCommand;
use RecruitmentApp\Application\Query\Article\ArticleQueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    public const RECORDS_PER_PAGE = 5;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var ArticleQueryInterface
     */
    private ArticleQueryInterface $articleQuery;

    /**
     * @param MessageBusInterface $messageBus
     * @param ArticleQueryInterface $articleQuery
     */
    public function __construct(
        MessageBusInterface $messageBus,
        ArticleQueryInterface $articleQuery,
    ) {
        $this->messageBus = $messageBus;
        $this->articleQuery = $articleQuery;
    }

    #[Route(path: '/articles', name: 'create_articles', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $payload = $request->request->all();

        $command = new CreateArticleCommand(
            (int)$payload['userId'],
            $payload['title'],
            $payload['content']
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['msg' => 'success'], Response::HTTP_CREATED);
    }

    #[Route(path: '/articles', name: 'get_articles', methods: ['GET'])]
    public function getAll(Request $request): JsonResponse
    {
        $articles = $this->articleQuery->getAll();

        return new JsonResponse(['articles' => $articles], Response::HTTP_OK);
    }

    #[Route(path: '/articles/page/{page}', name: 'get_articles_page', methods: ['GET'])]
    public function getPage(int $page): JsonResponse
    {
        $result = $this->articleQuery->getByPage(self::RECORDS_PER_PAGE, $page);

        return new JsonResponse(['articles' => $result['articles'], 'totalNumberOfPages' => $result['totalNumberOfPages']], Response::HTTP_OK);
    }
}

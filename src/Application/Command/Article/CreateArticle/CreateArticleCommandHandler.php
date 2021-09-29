<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Command\Article\CreateArticle;

use RecruitmentApp\Domain\Article;
use RecruitmentApp\Domain\Article\ArticleRepositoryInterface;
use RecruitmentApp\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateArticleCommandHandler implements MessageHandlerInterface
{
    /**
     * @var ArticleRepositoryInterface
     */
    private ArticleRepositoryInterface $articleRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @param ArticleRepositoryInterface $articleRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        UserRepositoryInterface $userRepository,
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateArticleCommand $command
     */
    public function __invoke(CreateArticleCommand $command)
    {
        $article = new Article(
            $this->userRepository->find($command->getAuthorId()),
            $command->getTitle(),
            $command->getContent()
        );
        $this->articleRepository->add($article);
    }
}

<?php
declare(strict_types=1);

namespace RecruitmentApp\Application\Command\User\CreateUser;

use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\ApiKey;

final class CreateUserCommand
{
    /**
     * @var Email
     */
    private Email $email;

    /**
     * @var ApiKey
     */
    private ApiKey $apiKey;

    /**
     * @param Email $email
     * @param ApiKey $apiKey
     */
    public function __construct(Email $email, ApiKey $apiKey)
    {
        $this->email = $email;
        $this->apiKey = $apiKey;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return ApiKey
     */
    public function getApiKey(): ApiKey
    {
        return $this->apiKey;
    }
}

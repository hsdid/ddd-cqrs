<?php
declare(strict_types=1);
namespace RecruitmentApp\Domain\User;

use JetBrains\PhpStorm\Pure;
use RecruitmentApp\Domain\Email;
use RecruitmentApp\Domain\User\ApiKey;

class UserView
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $apiKey;

    /**
     * @param int $id
     * @param Email $email
     * @param ApiKey $apiKey
     */
    #[Pure] public function __construct(int $id, Email $email, ApiKey $apiKey)
    {
        $this->email = $email->__toString();
        $this->apiKey = $apiKey->__toString();
        $this->id = $id;
    }
}

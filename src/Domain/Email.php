<?php
declare(strict_types=1);

namespace RecruitmentApp\Domain;

use Doctrine\ORM\Mapping as ORM;
use RecruitmentApp\Domain\Email\Exception\InvalidEmail;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type = "string", name="email")
     */
    private string $email;

    /**
     * @throws InvalidEmail
     */
    public function __construct(string $email)
    {
        if (empty($email) || false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail(sprintf('Invalid email: "%s"', $email));
        }

        $this->email = $email;
    }

    public function __toString()
    {
        return $this->email;
    }
}

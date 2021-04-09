<?php

declare(strict_types=1);

namespace Kodzila\Core\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Kodzila\Core\Domain\Policy\UserUniquenessPolicy;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 */
final class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    private function __construct(string $email)
    {
        $this->id = Uuid::uuid4();
        $this->email = $email;
        $this->password = '';
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserUniquenessPolicy $userUniquenessPolicy,
        string $email,
        string $password,
    ): self {
        $userUniquenessPolicy->check($email);
        Assert::email($email);

        $user = new User($email);
        $user->password = $userPasswordEncoder->encodePassword($user, $password);

        return $user;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return [];
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

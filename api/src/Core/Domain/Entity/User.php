<?php

declare(strict_types=1);

namespace Kodzila\Core\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Kodzila\Core\Domain\Policy\UserUniquenessPolicy;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 */
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'GET' => [
            'normalization_context' => [
                'groups' => ['user:read'],
            ],
            'security' => 'object === user',
        ],
    ],
)]
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $id;

    /**
     * @Groups({"user:read"})
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @Groups({"user:read"})
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

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}

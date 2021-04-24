<?php

declare(strict_types=1);

namespace Kodzila\Core\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 */
#[ApiResource(
    collectionOperations: [
        'POST' => [
            'security_post_denormalize' => 'is_granted("CAR_CREATE", object)',
        ],
        'GET_SELF' => [
            'method' => 'GET',
            'path' => '/self/cars',
        ],
    ],
    itemOperations: [
        'GET' => [
            'security' => 'object.user === user',
        ],
    ],
)]
class Car
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    public function __construct(User $user, string $name)
    {
        $this->id = Uuid::uuid4();
        $this->user = $user;
        $this->createdAt = new DateTimeImmutable();
        $this->name = $name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}

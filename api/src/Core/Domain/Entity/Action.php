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
        'POST' => [],
        'GET_SELF' => [
            'method' => 'GET',
            'path' => '/self/actions',
        ],
    ],
    itemOperations: [
        'GET' => [],
    ],
)]
class Action
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $id;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class)
     */
    private Car $car;

    /**
     * @ORM\ManyToOne(targetEntity=CarPart::class)
     */
    private CarPart $carPart;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="date_immutable")
     */
    public DateTimeImmutable $actionedAt;

    /**
     * @ORM\Column(type="float")
     */
    public float $cost;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $vendor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $distance;

    public function __construct(
        Car $car,
        CarPart $carPart,
        DateTimeImmutable $actionedAt,
        float $cost,
        ?string $description,
        ?string $vendor,
        ?int $distance
    ) {
        $this->id = Uuid::uuid4();
        $this->car = $car;
        $this->carPart = $carPart;
        $this->createdAt = new DateTimeImmutable();
        $this->actionedAt = $actionedAt;
        $this->cost = $cost;
        $this->description = $description;
        $this->vendor = $vendor;
        $this->distance = $distance;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getCarPart(): CarPart
    {
        return $this->carPart;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}

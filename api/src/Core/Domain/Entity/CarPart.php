<?php

declare(strict_types=1);

namespace Kodzila\Core\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ApiResource]
/**
 * @ORM\Entity
 */
class CarPart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }
}

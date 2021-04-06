<?php

declare(strict_types=1);

namespace Kodzila\Core\Presentation\Command;

use Doctrine\ORM\EntityManagerInterface;
use Kodzila\Core\Domain\Entity\CarPart;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SyncCarPartsCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:core:sync-car-parts')
            ->setDescription('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parts = [
            'Engine oil',
        ];

        $carPartRepository = $this->entityManager->getRepository(CarPart::class);

        foreach ($parts as $part) {
            if ($carPartRepository->findBy(['name' => $part])) {
                continue;
            }

            $newPart = new CarPart($part);
            $this->entityManager->persist($newPart);
        }

        $this->entityManager->flush();

        return 0;
    }
}

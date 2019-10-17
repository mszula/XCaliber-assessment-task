<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Domain;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\BonusRepositoryInterface;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BonusRepository extends ServiceEntityRepository implements BonusRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bonus::class);
    }

    public function getAllForTrigger(Trigger $trigger): array
    {
        return $this->findBy(
            ['trigger.value' => $trigger->getValue()]
        );
    }
}
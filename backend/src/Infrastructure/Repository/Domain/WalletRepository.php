<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Domain;

use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WalletRepository extends ServiceEntityRepository implements WalletRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function save(Wallet $wallet): void
    {
        $this->getEntityManager()->persist($wallet);
        $this->getEntityManager()->flush($wallet);
    }
}
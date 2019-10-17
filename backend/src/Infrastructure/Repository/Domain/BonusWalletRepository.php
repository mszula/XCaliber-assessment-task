<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Domain;

use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BonusWalletRepository extends ServiceEntityRepository implements BonusWalletRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BonusWallet::class);
    }

    public function getActiveBonusWallets(Player $player): array
    {
        return $this->findBy([
            'player' => $player,
            'status.value' => Status::ACTIVE,
        ]);
    }

    public function getActiveBonusNotFullWallets(Player $player): array
    {
        return $this->createQueryBuilder('bw')
            ->where('bw.player = :player')
            ->andWhere('bw.status.value = :status')
            ->andWhere('bw.currentValue.value < bw.initialValue.value')
            ->setParameter('player', $player)
            ->setParameter('status', Status::ACTIVE)
            ->getQuery()
            ->getResult();
    }

    public function save(BonusWallet $bonusWallet): void
    {
        $this->getEntityManager()->persist($bonusWallet);
        $this->getEntityManager()->flush($bonusWallet);
    }
}
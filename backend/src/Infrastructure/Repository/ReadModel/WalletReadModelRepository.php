<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\ReadModel;

use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\CommonWallet;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use App\ReadModel\Model\Wallet\WalletReadModelRepositoryInterface;
use App\ReadModel\Model\Wallet\ViewModel\BonusWalletInfo;
use App\ReadModel\Model\Wallet\ViewModel\WalletsInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WalletReadModelRepository extends ServiceEntityRepository implements WalletReadModelRepositoryInterface
{
    /** @var PlayerReadModelRepositoryInterface */
    private $playerReadModelRepository;

    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    public function __construct(PlayerReadModelRepositoryInterface $playerReadModelRepository, BonusWalletRepositoryInterface $bonusWalletRepository)
    {
        $this->playerReadModelRepository = $playerReadModelRepository;
        $this->bonusWalletRepository = $bonusWalletRepository;
    }

    public function getWalletsInfo(Uuid $playerId): WalletsInfo
    {
        $player = $this->playerReadModelRepository->getById($playerId);

        $bonusWalletsInfo = [];
        $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusWallets($player);
        foreach ($activeBonusWallets as $activeBonusWallet) {
            $bonusWalletsInfo[] = new BonusWalletInfo(
                $activeBonusWallet->getCurrentValue()->getValue(),
                $activeBonusWallet->getCurrency()->getValue(),
            );
        }

        return new WalletsInfo(
            $this->calculateTotalBalance($player)->getValue(),
            $player->getRealMoneyWallet()->getCurrency()->getValue(),
            $player->getRealMoneyWallet()->getCurrentValue()->getValue(),
            ...$bonusWalletsInfo,
        );
    }

    private function calculateTotalBalance(Player $player): Amount
    {
        $amount = $player->getRealMoneyWallet()->getCurrentValue()->getValue();

        $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusWallets($player);
        foreach ($activeBonusWallets as $activeBonusWallet) {
            $amount += $activeBonusWallet->getCurrentValue()->getValue();
        }

        return new Amount($amount);
    }
}
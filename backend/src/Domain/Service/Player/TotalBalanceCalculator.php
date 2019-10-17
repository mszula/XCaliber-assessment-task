<?php

declare(strict_types=1);

namespace App\Domain\Service\Player;

use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Shared\ValueObject\Amount;

class TotalBalanceCalculator
{
    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    public function __construct(BonusWalletRepositoryInterface $bonusWalletRepository)
    {
        $this->bonusWalletRepository = $bonusWalletRepository;
    }

    public function calculate(Player $player): Amount
    {
        $amount = $player->getRealMoneyWallet()->getCurrentValue()->getValue();

        $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusWallets($player);
        foreach ($activeBonusWallets as $activeBonusWallet) {
            $amount += $activeBonusWallet->getCurrentValue()->getValue();
        }

        return new Amount($amount);
    }
}
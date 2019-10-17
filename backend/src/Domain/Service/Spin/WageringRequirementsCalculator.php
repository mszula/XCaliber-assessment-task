<?php

declare(strict_types=1);

namespace App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\ValueObject\Amount;

class WageringRequirementsCalculator
{
    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    /** @var WalletRepositoryInterface */
    private $walletRepository;

    public function __construct(
        BonusWalletRepositoryInterface $bonusWalletRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->bonusWalletRepository = $bonusWalletRepository;
        $this->walletRepository = $walletRepository;
    }

    public function calculate(Amount $betAmount, Player $player): void
    {
        $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusWallets($player);

        foreach ($activeBonusWallets as $activeBonusWallet) {
            $activeBonusWallet->updateLeftWageringRequirements($betAmount);

            if ($activeBonusWallet->getStatus()->getValue() === Status::WAGERED) {
                $player->getRealMoneyWallet()->addMoney(
                    new Amount($activeBonusWallet->getCurrentValue()->getValue())
                );
            }

            $this->bonusWalletRepository->save($activeBonusWallet);
        }

        $this->walletRepository->save($player->getRealMoneyWallet());
    }
}
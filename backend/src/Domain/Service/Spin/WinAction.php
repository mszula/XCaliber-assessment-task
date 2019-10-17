<?php

declare(strict_types=1);

namespace App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Shared\ValueObject\Amount;

class WinAction
{
    private const WINNING_AMOUNT = 10;

    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    /** @var WalletRepositoryInterface */
    private $walletRepository;

    public function __construct(BonusWalletRepositoryInterface $bonusWalletRepository, WalletRepositoryInterface $walletRepository)
    {
        $this->bonusWalletRepository = $bonusWalletRepository;
        $this->walletRepository = $walletRepository;
    }

    public function win(Amount $betAmount, Player $player): void
    {
        $realMoneyWallet = $player->getRealMoneyWallet();

        $moneyLeftToPutInWallets = self::WINNING_AMOUNT;
        if ($this->usedBonusWallet($realMoneyWallet, $betAmount)) {
            $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusNotFullWallets($player);

            foreach ($activeBonusWallets as $activeBonusWallet) {
                $leftSpaceInWallet = $activeBonusWallet->getLeftSpace();

                if ($leftSpaceInWallet->getValue() <= $moneyLeftToPutInWallets) {
                    $activeBonusWallet->addMoney($activeBonusWallet->getLeftSpace());
                    $moneyLeftToPutInWallets -= $leftSpaceInWallet->getValue();
                } else {
                    $activeBonusWallet->addMoney(new Amount($moneyLeftToPutInWallets));
                    $moneyLeftToPutInWallets = 0;
                }

                $this->bonusWalletRepository->save($activeBonusWallet);

                if ($moneyLeftToPutInWallets === 0) {
                    break;
                }
            }
        }

        if ($moneyLeftToPutInWallets > 0) {
            $realMoneyWallet->addMoney(new Amount($moneyLeftToPutInWallets));

            $this->walletRepository->save($realMoneyWallet);
        }
    }

    private function usedBonusWallet(Wallet $wallet, Amount $amount): bool
    {
        return $wallet->getCurrentValue()->getValue() < $amount->getValue();
    }
}
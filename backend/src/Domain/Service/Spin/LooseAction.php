<?php

declare(strict_types=1);

namespace App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Shared\ValueObject\Amount;

class LooseAction
{
    private const LOOSING_AMOUNT = 10;

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

    public function loose(Amount $betAmount, Player $player): void
    {
        $realMoneyWallet = $player->getRealMoneyWallet();
        $moneyLeftToPickFromWallets = self::LOOSING_AMOUNT;

        if ($realMoneyWallet->getCurrentValue()->getValue() >= $moneyLeftToPickFromWallets) {
            $realMoneyWallet->subtractMoney(new Amount($moneyLeftToPickFromWallets));
        } else {
            $moneyLeftToPickFromWallets -= $realMoneyWallet->getCurrentValue()->getValue();

            $realMoneyWallet->zeroMoney();

            $activeBonusWallets = $this->bonusWalletRepository->getActiveBonusWallets($player);
            foreach ($activeBonusWallets as $activeBonusWallet) {
                if ($activeBonusWallet->getCurrentValue()->getValue() >= $moneyLeftToPickFromWallets) {
                    $activeBonusWallet->subtractMoney(new Amount($moneyLeftToPickFromWallets));
                    $moneyLeftToPickFromWallets = 0;
                } else {
                    $moneyLeftToPickFromWallets -= $activeBonusWallet->getCurrentValue()->getValue();
                    $activeBonusWallet->zeroMoney();
                }

                $this->bonusWalletRepository->save($activeBonusWallet);

                if ($moneyLeftToPickFromWallets === 0) {
                    break;
                }
            }
        }

        $this->walletRepository->save($realMoneyWallet);
    }
}
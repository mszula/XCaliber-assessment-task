<?php

declare(strict_types=1);

namespace App\Domain\Service\Bonus;

use App\Domain\Factory\BonusWalletFactory;
use App\Domain\Model\Bonus\BonusRepositoryInterface;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Shared\ValueObject\Amount;

class TriggerBonusResolver
{
    /** @var BonusRepositoryInterface */
    private $bonusRepository;

    /** @var WalletRepositoryInterface */
    private $walletRepository;

    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    /** @var BonusWalletFactory */
    private $bonusWalletFactory;

    public function __construct(
        BonusRepositoryInterface $bonusRepository,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        BonusWalletFactory $bonusWalletFactory
    )
    {
        $this->bonusRepository = $bonusRepository;
        $this->walletRepository = $walletRepository;
        $this->bonusWalletRepository = $bonusWalletRepository;
        $this->bonusWalletFactory = $bonusWalletFactory;
    }

    public function action(Trigger $trigger, Player $player, ?Amount $depositAmount = null)
    {
        $bonuses = $this->bonusRepository->getAllForTrigger($trigger);

        foreach ($bonuses as $bonus) {
            if ($bonus->getRewardType()->isRealMoney()) {
                $player->getRealMoneyWallet()->addMoney(new Amount($bonus->getRewardValue()->getValue()));

                $this->walletRepository->save($player->getRealMoneyWallet());
            } else {
                $this->bonusWalletRepository->save(
                    $this->bonusWalletFactory->create($bonus, $player, $depositAmount)
                );
            }
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\API\MakeDeposit;

use App\Domain\Model\Bonus\BonusRepositoryInterface;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Bonus\TriggerBonusResolver;

final class MakeDepositHandler
{
    /** @var BonusRepositoryInterface */
    private $bonusRepository;

    /** @var WalletRepositoryInterface */
    private $walletRepository;

    /** @var BonusWalletRepositoryInterface */
    private $bonusWalletRepository;

    /** @var TriggerBonusResolver */
    private $triggerBonusResolver;

    public function __construct(
        BonusRepositoryInterface $bonusRepository,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        TriggerBonusResolver $triggerBonusResolver
    )
    {
        $this->bonusRepository = $bonusRepository;
        $this->walletRepository = $walletRepository;
        $this->bonusWalletRepository = $bonusWalletRepository;
        $this->triggerBonusResolver = $triggerBonusResolver;
    }

    public function handle(MakeDepositCommand $command): void
    {
        $realMoneyWallet = $command->getPlayer()->getRealMoneyWallet();

        $realMoneyWallet->addMoney($command->getAmount());

        $this->walletRepository->save($realMoneyWallet);

        $this->triggerBonusResolver->action(
            new Trigger(Trigger::DEPOSIT),
            $command->getPlayer(),
            $command->getAmount()
        );
    }
}
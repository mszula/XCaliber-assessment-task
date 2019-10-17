<?php

namespace spec\App\Domain\API\MakeDeposit;

use App\Domain\API\MakeDeposit\MakeDepositCommand;
use App\Domain\API\MakeDeposit\MakeDepositHandler;
use App\Domain\Model\Bonus\BonusRepositoryInterface;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Bonus\TriggerBonusResolver;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class MakeDepositHandlerSpec extends ObjectBehavior
{
    function let(
        BonusRepositoryInterface $bonusRepository,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        TriggerBonusResolver $triggerBonusResolver
    )
    {
        $this->beConstructedWith($bonusRepository, $walletRepository, $bonusWalletRepository, $triggerBonusResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MakeDepositHandler::class);
    }

    function it_is_make_deposit(
        Wallet $wallet,
        Player $player,
        WalletRepositoryInterface $walletRepository,
        TriggerBonusResolver $triggerBonusResolver
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $command = new MakeDepositCommand(10, $player->getWrappedObject());

        $wallet->addMoney($command->getAmount())->shouldBeCalled();
        $walletRepository->save($wallet)->shouldBeCalled();

        $triggerBonusResolver->action(new Trigger(Trigger::DEPOSIT), $player, $command->getAmount())->shouldBeCalled();

        $this->handle($command)->shouldBeNull();


    }
}

<?php

namespace spec\App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Spin\WageringRequirementsCalculator;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Yaml\Tests\A;

class WageringRequirementsCalculatorSpec extends ObjectBehavior
{
    function let(
        BonusWalletRepositoryInterface $bonusWalletRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->beConstructedWith($bonusWalletRepository, $walletRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WageringRequirementsCalculator::class);
    }

    function it_is_calculate_wagering_requirements(
        Player $player,
        Wallet $wallet,
        BonusWallet $bonusWallet,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $betAmount = new Amount(10);
        $bonusWallet->updateLeftWageringRequirements($betAmount)->shouldBeCalledOnce();
        $bonusWallet->getStatus()->willReturn(new Status(Status::ACTIVE));
        $bonusWalletRepository->getActiveBonusWallets($player)->willReturn([$bonusWallet]);

        $wallet->addMoney(Argument::type(Amount::class))->shouldNotBeCalled();

        $bonusWalletRepository->save($bonusWallet)->shouldBeCalledOnce();
        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $this->calculate($betAmount, $player)->shouldBeNull();
    }

    function it_is_calculate_wagering_requirements_and_add_money(
        Player $player,
        Wallet $wallet,
        BonusWallet $bonusWallet,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $betAmount = new Amount(10);
        $bonusWallet->updateLeftWageringRequirements($betAmount)->shouldBeCalledOnce();
        $bonusWallet->getStatus()->willReturn(new Status(Status::WAGERED));
        $bonusWallet->getCurrentValue()->willReturn(new CurrentValue(20));
        $bonusWalletRepository->getActiveBonusWallets($player)->willReturn([$bonusWallet]);

        $wallet->addMoney(new Amount(20))->shouldBeCalled();

        $bonusWalletRepository->save($bonusWallet)->shouldBeCalledOnce();
        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $this->calculate($betAmount, $player)->shouldBeNull();
    }
}

<?php

namespace spec\App\Domain\Service\Player;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Service\Player\TotalBalanceCalculator;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class TotalBalanceCalculatorSpec extends ObjectBehavior
{
    function let(BonusWalletRepositoryInterface $bonusWalletRepository)
    {
        $this->beConstructedWith($bonusWalletRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TotalBalanceCalculator::class);
    }

    function it_is_calculate_total_balance(
        Player $player,
        BonusWallet $bonusWallet1,
        BonusWallet $bonusWallet2,
        BonusWalletRepositoryInterface $bonusWalletRepository
    )
    {
        $wallet = new Wallet(new Uuid('0de36b41-ff5f-4da4-bbab-c9501b346272'), new InitialValue(10), $player->getWrappedObject());
        $player->getRealMoneyWallet()->willReturn($wallet);
        $bonusWallet1->getCurrentValue()->willReturn(new CurrentValue(5));
        $bonusWallet2->getCurrentValue()->willReturn(new CurrentValue(123));
        $bonusWalletRepository->getActiveBonusWallets($player)->willReturn([
            $bonusWallet1,
            $bonusWallet2
        ]);

        $this->calculate($player)->getValue()->shouldBe(138);
    }
}

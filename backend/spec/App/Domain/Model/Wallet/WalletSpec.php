<?php

namespace spec\App\Domain\Model\Wallet;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class WalletSpec extends ObjectBehavior
{
    function let(Player $player, Bonus $bonus)
    {
        $this->beConstructedWith(
            new Uuid('4dc97417-6da6-4ddf-9eda-b2f7f8d122df'),
            new InitialValue(10),
            $player,
            $bonus
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Wallet::class);

        $this->getCurrency()->getValue()->shouldBe(Currency::EUR);
        $this->getInitialValue()->getValue()->shouldBe(10);
        $this->getCurrentValue()->getValue()->shouldBe(10);
        $this->getStatus()->getValue()->shouldBe(Status::ACTIVE);
    }

    function it_is_able_to_update()
    {
        $this->update(new CurrentValue(100));

        $this->getCurrentValue()->getValue()->shouldBe(100);
    }

    function it_is_able_to_add_money()
    {
        $this->addMoney(new Amount(22));

        $this->getCurrentValue()->getValue()->shouldBe(32);
    }

    function it_is_able_to_subtract_money()
    {
        $this->subtractMoney(new Amount(4));

        $this->getCurrentValue()->getValue()->shouldBe(6);
    }

    function it_is_able_to_zero_money()
    {
        $this->zeroMoney();

        $this->getCurrentValue()->getValue()->shouldBe(0);
    }
}

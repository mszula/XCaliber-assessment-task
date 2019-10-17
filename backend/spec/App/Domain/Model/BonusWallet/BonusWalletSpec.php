<?php

namespace spec\App\Domain\Model\BonusWallet;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\Exception\InvalidCurrentValue;
use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class BonusWalletSpec extends ObjectBehavior
{
    function let(Player $player, Bonus $bonus)
    {
        $bonus->getWageringMultiplier()->willReturn(new WageringMultiplier(20));

        $this->beConstructedWith(
            new Uuid('4dc97417-6da6-4ddf-9eda-b2f7f8d122df'),
            new InitialValue(10),
            $player,
            $bonus
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BonusWallet::class);

        $this->getCurrency()->getValue()->shouldBe(Currency::BNS);
        $this->getInitialValue()->getValue()->shouldBe(10);
        $this->getCurrentValue()->getValue()->shouldBe(10);
        $this->getStatus()->getValue()->shouldBe(Status::ACTIVE);
        $this->getLeftWageringRequirements()->getValue(200);
    }

    function it_is_able_to_update()
    {
        $this->update(new CurrentValue(5));

        $this->getCurrentValue()->getValue()->shouldBe(5);
    }

    function it_is_change_status_after_updated_to_zero()
    {
        $this->update(new CurrentValue(0));

        $this->getCurrentValue()->getValue()->shouldBe(0);
        $this->getStatus()->getValue()->shouldBe(Status::DEPLETED);
    }

    function it_is_throw_an_exception_while_update_higher_than_initial_value()
    {
        $this->shouldThrow(InvalidCurrentValue::currentValueIsTooHigh($this->getInitialValue()->getWrappedObject()))
            ->during('update', [new CurrentValue(12)]);
    }

    function it_it_update_left_wagering_requirements()
    {
        $this->updateLeftWageringRequirements(new Amount(120));

        $this->getLeftWageringRequirements()->getValue()->shouldBe(80);
    }

    function it_it_update_left_wagering_requirements_and_set_new_status()
    {
        $this->updateLeftWageringRequirements(new Amount(250));

        $this->getLeftWageringRequirements()->getValue()->shouldBe(0);
        $this->getStatus()->getValue()->shouldBe(Status::WAGERED);
    }
}

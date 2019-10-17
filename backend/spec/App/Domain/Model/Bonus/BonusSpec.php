<?php

namespace spec\App\Domain\Model\Bonus;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\Exception\InvalidTrigger;
use App\Domain\Model\Bonus\ValueObject\Name;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Shared\Model\Uuid;
use PhpSpec\ObjectBehavior;

class BonusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(
            new Uuid('d5cee96e-6343-49e1-bba9-002cd895f235'),
            new Name('test'),
            new Trigger(Trigger::DEPOSIT),
            new RewardValue(10),
            new RewardType(RewardType::BONUS_MONEY),
            new WageringMultiplier(10)
        );
        $this->shouldHaveType(Bonus::class);
    }

    function it_is_throw_an_invalid_trigger_exception()
    {
        $this->beConstructedWith(
            new Uuid('d5cee96e-6343-49e1-bba9-002cd895f235'),
            new Name('test'),
            new Trigger(Trigger::LOGIN),
            new RewardValue(10),
            new RewardType(RewardType::PERCENT_OF_DEPOSIT),
            new WageringMultiplier(10)
        );

        $this->shouldThrow(InvalidTrigger::mismatchedTriggerAndRewardType())
            ->duringInstantiation();
    }
}

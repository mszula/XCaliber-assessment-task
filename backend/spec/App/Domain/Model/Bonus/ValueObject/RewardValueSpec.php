<?php

namespace spec\App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidRewardValue;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use PhpSpec\ObjectBehavior;

class RewardValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10);
        $this->shouldHaveType(RewardValue::class);
    }

    function it_is_should_throw_an_smaller_than_one_exception()
    {
        $this->beConstructedWith(0);
        $this->shouldThrow(InvalidRewardValue::smallerThanOne())->duringInstantiation();
    }
}

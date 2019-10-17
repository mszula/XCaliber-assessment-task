<?php

namespace spec\App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidRewardType;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use PhpSpec\ObjectBehavior;

class RewardTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(RewardType::BONUS_MONEY);
        $this->shouldHaveType(RewardType::class);
    }

    function it_is_should_throw_an_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidRewardType::empty())->duringInstantiation();
    }

    function it_is_should_throw_an_invalid_value_exception()
    {
        $this->beConstructedWith('test');
        $this->shouldThrow(InvalidRewardType::invalidValue('test'))->duringInstantiation();
    }
}

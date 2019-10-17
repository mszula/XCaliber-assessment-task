<?php

namespace spec\App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidCurrentValue;
use PhpSpec\ObjectBehavior;

class CurrentValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10);
        $this->shouldHaveType(CurrentValue::class);
    }

    function it_is_should_too_low_exception()
    {
        $this->beConstructedWith(-1);
        $this->shouldThrow(InvalidCurrentValue::lowerThanZero())->duringInstantiation();
    }
}

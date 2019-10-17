<?php

namespace spec\App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidWageringMultiplier;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use PhpSpec\ObjectBehavior;

class WageringMultiplierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(100);
        $this->shouldHaveType(WageringMultiplier::class);
    }

    function it_is_should_throw_an_to_low_exception()
    {
        $this->beConstructedWith(-10);
        $this->shouldThrow(InvalidWageringMultiplier::smallerThanOne())->duringInstantiation();
    }

    function it_is_should_throw_an_to_high_exception()
    {
        $this->beConstructedWith(123);
        $this->shouldThrow(InvalidWageringMultiplier::biggerThanHundred())->duringInstantiation();
    }
}

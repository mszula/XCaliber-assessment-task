<?php

namespace spec\App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Exception\InvalidAmount;
use PhpSpec\ObjectBehavior;

class AmountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10);
        $this->shouldHaveType(Amount::class);
    }

    function it_is_should_throw_an_too_low_exception()
    {
        $this->beConstructedWith(-1);
        $this->shouldThrow(InvalidAmount::lowerThanZero())->duringInstantiation();
    }
}

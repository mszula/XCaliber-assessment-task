<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Age;
use App\Domain\Model\Player\ValueObject\Exception\InvalidAge;
use PhpSpec\ObjectBehavior;

class AgeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(20);
        $this->shouldHaveType(Age::class);
    }

    function it_is_should_too_low_exception()
    {
        $this->beConstructedWith(0);
        $this->shouldThrow(InvalidAge::lowerThanOne())->duringInstantiation();
    }
}

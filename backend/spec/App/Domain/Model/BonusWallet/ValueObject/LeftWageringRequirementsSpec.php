<?php

namespace spec\App\Domain\Model\BonusWallet\ValueObject;

use App\Domain\Model\BonusWallet\ValueObject\Exception\InvalidLeftWageringRequirements;
use App\Domain\Model\BonusWallet\ValueObject\LeftWageringRequirements;
use PhpSpec\ObjectBehavior;

class LeftWageringRequirementsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(100);
        $this->shouldHaveType(LeftWageringRequirements::class);
    }

    function it_is_should_throw_an_too_low_exception()
    {
        $this->beConstructedWith(-10);
        $this->shouldThrow(InvalidLeftWageringRequirements::smallerThanZero())->duringInstantiation();
    }
}

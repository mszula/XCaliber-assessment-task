<?php

namespace spec\App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidInitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use PhpSpec\ObjectBehavior;

class InitialValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10);
        $this->shouldHaveType(InitialValue::class);
    }

    function it_is_should_too_low_exception()
    {
        $this->beConstructedWith(-1);
        $this->shouldThrow(InvalidInitialValue::lowerThanZero())->duringInstantiation();
    }
}

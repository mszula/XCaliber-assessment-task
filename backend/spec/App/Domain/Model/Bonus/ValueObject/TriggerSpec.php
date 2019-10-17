<?php

namespace spec\App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidTrigger;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use PhpSpec\ObjectBehavior;

class TriggerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Trigger::DEPOSIT);
        $this->shouldHaveType(Trigger::class);
    }

    function it_is_should_throw_an_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidTrigger::empty())->duringInstantiation();
    }

    function it_is_should_throw_an_invalid_value_exception()
    {
        $this->beConstructedWith('test');
        $this->shouldThrow(InvalidTrigger::invalidValue('test'))->duringInstantiation();
    }
}

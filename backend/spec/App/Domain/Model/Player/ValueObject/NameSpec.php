<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidName;
use App\Domain\Model\Player\ValueObject\Name;
use PhpSpec\ObjectBehavior;

class NameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('John');
        $this->shouldHaveType(Name::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidName::empty())->duringInstantiation();
    }
}

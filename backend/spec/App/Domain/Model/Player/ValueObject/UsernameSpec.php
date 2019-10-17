<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidUsername;
use App\Domain\Model\Player\ValueObject\Username;
use PhpSpec\ObjectBehavior;

class UsernameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('test');
        $this->shouldHaveType(Username::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidUsername::empty())->duringInstantiation();
    }
}

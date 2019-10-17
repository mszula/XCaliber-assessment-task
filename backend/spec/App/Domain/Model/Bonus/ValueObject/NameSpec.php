<?php

namespace spec\App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidName;
use App\Domain\Model\Bonus\ValueObject\Name;
use PhpSpec\ObjectBehavior;

class NameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('test');
        $this->shouldHaveType(Name::class);
    }

    function it_is_should_throw_an_exception()
    {
        $this->beConstructedWith('');

        $this->shouldThrow(InvalidName::empty())->duringInstantiation();
    }
}

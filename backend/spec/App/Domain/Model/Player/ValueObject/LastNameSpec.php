<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidLastName;
use App\Domain\Model\Player\ValueObject\LastName;
use PhpSpec\ObjectBehavior;

class LastNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Doe');
        $this->shouldHaveType(LastName::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidLastName::empty())->duringInstantiation();
    }
}

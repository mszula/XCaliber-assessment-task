<?php

namespace spec\App\Domain\Shared\Model;

use App\Domain\Shared\Model\Exception\InvalidUuid;
use App\Domain\Shared\Model\Uuid;
use PhpSpec\ObjectBehavior;

class UuidSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('0a5280c7-6bfe-45b4-ad13-846488609076');
        $this->shouldHaveType(Uuid::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidUuid::empty())->duringInstantiation();
    }

    function it_is_should_throw_invalid_value_exception()
    {
        $this->beConstructedWith('6bfe');
        $this->shouldThrow(InvalidUuid::invalidValue())->duringInstantiation();
    }
}

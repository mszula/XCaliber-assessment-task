<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidGender;
use App\Domain\Model\Player\ValueObject\Gender;
use PhpSpec\ObjectBehavior;

class GenderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Gender::MALE);
        $this->shouldHaveType(Gender::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidGender::empty())->duringInstantiation();
    }

    function it_is_should_throw_invalid_value_exception()
    {
        $this->beConstructedWith('HELICOPTER TOMAHAWK');
        $this->shouldThrow(InvalidGender::invalidValue('HELICOPTER TOMAHAWK'))->duringInstantiation();
    }
}

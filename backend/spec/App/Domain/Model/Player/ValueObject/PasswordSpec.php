<?php

namespace spec\App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidPassword;
use App\Domain\Model\Player\ValueObject\Password;
use PhpSpec\ObjectBehavior;

class PasswordSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('test');
        $this->shouldHaveType(Password::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidPassword::empty())->duringInstantiation();
    }
}

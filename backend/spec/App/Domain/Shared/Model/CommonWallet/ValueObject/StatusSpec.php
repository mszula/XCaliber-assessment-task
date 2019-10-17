<?php

namespace spec\App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidStatus;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use PhpSpec\ObjectBehavior;

class StatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Status::ACTIVE);
        $this->shouldHaveType(Status::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidStatus::empty())->duringInstantiation();
    }

    function it_is_should_throw_invalid_value_exception()
    {
        $this->beConstructedWith('NEW');
        $this->shouldThrow(InvalidStatus::invalidValue('NEW'))->duringInstantiation();
    }
}

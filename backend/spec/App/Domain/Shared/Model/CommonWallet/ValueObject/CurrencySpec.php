<?php

namespace spec\App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidCurrency;
use PhpSpec\ObjectBehavior;

class CurrencySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Currency::EUR);
        $this->shouldHaveType(Currency::class);
    }

    function it_is_should_throw_empty_value_exception()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidCurrency::empty())->duringInstantiation();
    }

    function it_is_should_throw_invalid_value_exception()
    {
        $this->beConstructedWith('PLN');
        $this->shouldThrow(InvalidCurrency::invalidValue('PLN'))->duringInstantiation();
    }
}

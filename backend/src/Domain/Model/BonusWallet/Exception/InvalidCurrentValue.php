<?php

declare(strict_types=1);

namespace App\Domain\Model\BonusWallet\Exception;

use App\Domain\Exception\InvalidArgument;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;

class InvalidCurrentValue extends InvalidArgument
{
    public static function currentValueIsTooHigh(InitialValue $initialValue): self
    {
        return new self(sprintf('Given current value is too high. Maximum is %d', $initialValue->getValue()));
    }
}
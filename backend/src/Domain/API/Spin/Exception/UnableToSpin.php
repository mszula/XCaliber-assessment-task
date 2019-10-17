<?php

declare(strict_types=1);

namespace App\Domain\API\Spin\Exception;

use App\Domain\Exception\DomainException;
use App\Domain\Shared\ValueObject\Amount;

class UnableToSpin extends DomainException
{
    public static function betAmountIsTooHigh(Amount $currentValue): self
    {
        return new self(sprintf('Bet amount is too high. Maximum is %d', $currentValue->getValue()));
    }
}
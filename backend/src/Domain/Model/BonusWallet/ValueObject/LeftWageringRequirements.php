<?php

declare(strict_types=1);

namespace App\Domain\Model\BonusWallet\ValueObject;

use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Model\BonusWallet\ValueObject\Exception\InvalidLeftWageringRequirements;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class LeftWageringRequirements extends IntegerValueObject
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw InvalidLeftWageringRequirements::smallerThanZero();
        }

        parent::__construct($value);
    }

    public static function initialize(InitialValue $initialValue, WageringMultiplier $wageringMultiplier): self
    {
        return new self($initialValue->getValue() * $wageringMultiplier->getValue());
    }

    public function subtract(Amount $amount): self
    {
        $value = $this->value - $amount->value;
        if ($value < 0) {
            $value = 0;
        }

        return new self($value);
    }
}
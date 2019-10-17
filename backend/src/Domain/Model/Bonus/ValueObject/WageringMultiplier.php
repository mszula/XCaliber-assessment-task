<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidWageringMultiplier;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class WageringMultiplier extends IntegerValueObject
{
    private const MIN_VALUE = 0;
    private const MAX_VALUE = 100;

    public function __construct(int $value)
    {
        if ($value <= self::MIN_VALUE) {
            throw InvalidWageringMultiplier::smallerThanOne();
        }
        if ($value > self::MAX_VALUE) {
            throw InvalidWageringMultiplier::biggerThanHundred();
        }

        parent::__construct($value);
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidWageringMultiplier extends InvalidArgument
{
    public static function smallerThanOne(): self
    {
        return new self('Bonus wagering multiplier can\'t be smaller than one.');
    }

    public static function biggerThanHundred(): self
    {
        return new self('Bonus wagering multiplier can\'t be bigger than hundred.');
    }
}
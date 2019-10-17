<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Exception\InvalidAmount;

class Amount extends IntegerValueObject
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw InvalidAmount::lowerThanZero();
        }

        parent::__construct($value);
    }
}
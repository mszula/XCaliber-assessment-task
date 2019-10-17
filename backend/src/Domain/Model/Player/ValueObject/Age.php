<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidAge;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class Age extends IntegerValueObject
{
    public function __construct(int $value)
    {
        if ($value < 1) {
            throw InvalidAge::lowerThanOne();
        }

        parent::__construct($value);
    }
}
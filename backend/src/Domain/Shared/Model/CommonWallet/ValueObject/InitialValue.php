<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidInitialValue;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class InitialValue extends IntegerValueObject
{
    public function __construct(int $value)
    {
        $this->validate($value);

        parent::__construct($value);
    }

    private function validate(int $value): void
    {
        if ($value < 0) {
            throw InvalidInitialValue::lowerThanZero();
        }
    }
}
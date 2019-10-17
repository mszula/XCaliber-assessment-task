<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\API\ValueObject\Amount;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidCurrentValue;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class CurrentValue extends IntegerValueObject
{
    public function __construct(int $value)
    {
        $this->validate($value);

        parent::__construct($value);
    }

    private function validate(int $value): void
    {
        if ($value < 0) {
            throw InvalidCurrentValue::lowerThanZero();
        }
    }
}
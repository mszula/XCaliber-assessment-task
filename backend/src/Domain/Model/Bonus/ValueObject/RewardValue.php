<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidRewardValue;
use App\Domain\Shared\ValueObject\IntegerValueObject;

class RewardValue extends IntegerValueObject
{
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw InvalidRewardValue::smallerThanOne();
        }

        parent::__construct($value);
    }
}
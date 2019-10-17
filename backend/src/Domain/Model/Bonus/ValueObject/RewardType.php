<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidRewardType;
use App\Domain\Shared\ValueObject\StringValueObject;

class RewardType extends StringValueObject
{
    public const PERCENT_OF_DEPOSIT = 'PERCENT_OF_DEPOSIT';
    public const BONUS_MONEY = 'BONUS_MONEY';
    public const REAL_MONEY = 'REAL_MONEY';

    public const CHOICES = [
        self::PERCENT_OF_DEPOSIT,
        self::BONUS_MONEY,
        self::REAL_MONEY,
    ];

    public function __construct(string $value)
    {
        if (!mb_strlen($value)) {
            throw InvalidRewardType::empty();
        }
        if (!in_array($value, self::CHOICES, true)) {
            throw InvalidRewardType::invalidValue($value);
        }

        parent::__construct($value);
    }

    public function isRealMoney(): bool
    {
        return $this->getValue() === self::REAL_MONEY;
    }
}
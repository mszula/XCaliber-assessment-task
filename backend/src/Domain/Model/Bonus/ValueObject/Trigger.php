<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject;

use App\Domain\Model\Bonus\ValueObject\Exception\InvalidTrigger;
use App\Domain\Shared\ValueObject\StringValueObject;

class Trigger extends StringValueObject
{
    public const DEPOSIT = 'DEPOSIT';
    public const LOGIN = 'LOGIN';

    public const CHOICES = [
        self::DEPOSIT,
        self::LOGIN,
    ];

    public function __construct(string $value)
    {
        if (!mb_strlen($value)) {
            throw InvalidTrigger::empty();
        }
        if (!in_array($value, self::CHOICES, true)) {
            throw InvalidTrigger::invalidValue($value);
        }

        parent::__construct($value);
    }
}
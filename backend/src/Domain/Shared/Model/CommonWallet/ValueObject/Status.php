<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidStatus;
use App\Domain\Shared\ValueObject\StringValueObject;

class Status extends StringValueObject
{
    public const ACTIVE = 'ACTIVE';
    public const WAGERED = 'WAGERED';
    public const DEPLETED = 'DEPLETED';

    public const CHOICES = [
        self::ACTIVE,
        self::WAGERED,
        self::DEPLETED,
    ];

    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidStatus::empty();
        }
        if (!\in_array($value, self::CHOICES, true)) {
            throw InvalidStatus::invalidValue($value);
        }

        parent::__construct($value);
    }
}
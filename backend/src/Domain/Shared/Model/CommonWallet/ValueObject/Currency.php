<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject;

use App\Domain\Shared\Model\CommonWallet\ValueObject\Exception\InvalidCurrency;
use App\Domain\Shared\ValueObject\StringValueObject;

class Currency extends StringValueObject
{
    public const EUR = 'EUR';
    public const BNS = 'BNS';

    public const CHOICES = [
        self::EUR,
        self::BNS,
    ];

    public function __construct(string $value)
    {
        if (!mb_strlen($value)) {
            throw InvalidCurrency::empty();
        }
        if (!in_array($value, self::CHOICES, true)) {
            throw InvalidCurrency::invalidValue($value);
        }

        parent::__construct($value);
    }
}
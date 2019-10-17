<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidGender;
use App\Domain\Shared\ValueObject\StringValueObject;

class Gender extends StringValueObject
{
    public const MALE = 'M';
    public const FEMALE = 'F';

    public const CHOICES = [
        self::MALE,
        self::FEMALE,
    ];

    public function __construct(string $value)
    {
        if (!mb_strlen($value)) {
            throw InvalidGender::empty();
        }
        if (!in_array($value, self::CHOICES, true)) {
            throw InvalidGender::invalidValue($value);
        }

        parent::__construct($value);
    }
}
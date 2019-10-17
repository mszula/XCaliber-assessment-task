<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model;

use App\Domain\Shared\Model\Exception\InvalidUuid;
use App\Domain\Shared\ValueObject\StringValueObject;

class Uuid extends StringValueObject
{
    private const VALIDATOR_PREG = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidUuid::empty();
        }
        if (!\preg_match(self::VALIDATOR_PREG, $value)) {
            throw InvalidUuid::invalidValue();
        }

        parent::__construct($value);
    }
}
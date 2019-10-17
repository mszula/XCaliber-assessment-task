<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidName;
use App\Domain\Shared\ValueObject\StringValueObject;

class Name extends StringValueObject
{
    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidName::empty();
        }

        parent::__construct($value);
    }
}
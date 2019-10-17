<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidLastName;
use App\Domain\Shared\ValueObject\StringValueObject;

class LastName extends StringValueObject
{
    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidLastName::empty();
        }

        parent::__construct($value);
    }
}
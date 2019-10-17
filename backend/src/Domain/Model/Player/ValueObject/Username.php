<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidUsername;
use App\Domain\Shared\ValueObject\StringValueObject;

class Username extends StringValueObject
{
    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidUsername::empty();
        }

        parent::__construct($value);
    }
}
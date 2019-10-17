<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject;

use App\Domain\Model\Player\ValueObject\Exception\InvalidPassword;
use App\Domain\Shared\ValueObject\StringValueObject;

class Password extends StringValueObject
{
    public function __construct(string $value)
    {
        if (!\mb_strlen($value)) {
            throw InvalidPassword::empty();
        }

        parent::__construct($value);
    }
}
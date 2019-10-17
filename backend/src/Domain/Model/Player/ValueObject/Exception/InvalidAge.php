<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidAge extends InvalidArgument
{
    public static function lowerThanOne(): self
    {
        return new self('Player age can\'t be lower than one.');
    }
}
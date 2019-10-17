<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidAmount extends InvalidArgument
{
    public static function lowerThanZero(): self
    {
        return new self('Amount value can\'t be lower than zero.');
    }
}
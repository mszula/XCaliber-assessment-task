<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidGender extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Player gender can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        return new self(sprintf('Player gender has invalid value "%s".', $value));
    }
}
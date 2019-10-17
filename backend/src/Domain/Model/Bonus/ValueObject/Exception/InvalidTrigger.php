<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidTrigger extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Bonus trigger can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        return new self(sprintf('Bonus trigger has invalid value "%s".', $value));
    }
}
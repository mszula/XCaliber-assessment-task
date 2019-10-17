<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidRewardType extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Bonus reward type can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        return new self(sprintf('Bonus reward type has invalid value "%s".', $value));
    }
}
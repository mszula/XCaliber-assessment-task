<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidStatus extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Wallet status can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        return new self(sprintf('Wallet status has invalid value "%s".', $value));
    }
}
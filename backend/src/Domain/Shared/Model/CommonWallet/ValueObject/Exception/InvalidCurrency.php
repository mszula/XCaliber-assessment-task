<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidCurrency extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Wallet currency can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        return new self(sprintf('Wallet currency has invalid value "%s".', $value));
    }
}
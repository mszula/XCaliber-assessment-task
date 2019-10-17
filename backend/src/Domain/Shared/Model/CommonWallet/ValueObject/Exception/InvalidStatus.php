<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\Exception;

use App\Domain\Shared\Model\CommonWallet\InvalidArgument;

class InvalidStatus extends InvalidArgument
{
    public static function empty(): self
    {
        new self('Wallet status can\'t be empty.');
    }

    public static function invalidValue(string $value): self
    {
        new self(sprintf('Wallet status has invalid value "%s".', $value));
    }
}
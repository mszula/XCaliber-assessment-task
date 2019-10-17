<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidInitialValue extends InvalidArgument
{
    public static function lowerThanZero(): self
    {
        return new self('Initial value can\'t be smaller than zero.');
    }
}
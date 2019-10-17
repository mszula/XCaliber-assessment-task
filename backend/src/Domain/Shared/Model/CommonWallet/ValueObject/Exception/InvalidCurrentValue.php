<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidCurrentValue extends InvalidArgument
{
    public static function smallerThanOne(): self
    {
        new self('Current value can\'t be smaller than zero.');
    }
}
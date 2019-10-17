<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidName extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Bonus name can\'t be empty.');
    }
}
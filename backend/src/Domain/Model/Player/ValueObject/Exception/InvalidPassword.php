<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidPassword extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Player password can\'t be empty.');
    }
}
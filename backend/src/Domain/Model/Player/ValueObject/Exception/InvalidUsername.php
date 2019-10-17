<?php

declare(strict_types=1);

namespace App\Domain\Model\Player\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidUsername extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Player username can\'t be empty.');
    }
}
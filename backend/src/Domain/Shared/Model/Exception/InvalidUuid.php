<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidUuid extends InvalidArgument
{
    public static function empty(): self
    {
        return new self('Uuid can\'t be empty.');
    }

    public static function invalidValue(): self
    {
        return new self('Uuid has invalid value');
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidRewardValue extends InvalidArgument
{
    public static function smallerThanOne(): self
    {
        return new self('Bonus reward value can\'t be smaller than one.');
    }
}
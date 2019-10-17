<?php

declare(strict_types=1);

namespace App\Domain\Model\BonusWallet\ValueObject\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidLeftWageringRequirements extends InvalidArgument
{
    public static function smallerThanZero(): self
    {
        return new self('Left Wagering Requirements value can\'t be smaller than zero.');
    }
}
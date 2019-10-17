<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus\Exception;

use App\Domain\Exception\InvalidArgument;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\Trigger;

class InvalidTrigger extends InvalidArgument
{
    public static function mismatchedTriggerAndRewardType(): self
    {
        return new self(sprintf(
            'Trigger "%s", can\'t be used with Reward type "%s". Please change one of them.',
            Trigger::LOGIN,
            RewardType::PERCENT_OF_DEPOSIT
        ));
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus;

use App\Domain\Model\Bonus\Exception\InvalidTrigger;
use App\Domain\Model\Bonus\ValueObject\Name;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Shared\Model\Uuid;

class Bonus
{
    /** @var Uuid */
    private $id;

    /** @var Name */
    private $name;

    /** @var Trigger */
    private $trigger;

    /** @var RewardValue */
    private $rewardValue;

    /** @var RewardType */
    private $rewardType;

    /** @var WageringMultiplier */
    private $wageringMultiplier;

    public function __construct(
        Uuid $uuid,
        Name $name,
        Trigger $trigger,
        RewardValue $rewardValue,
        RewardType $rewardType,
        WageringMultiplier $wageringMultiplier
    )
    {
        $this->id = $uuid;
        $this->name = $name;
        $this->trigger = $trigger;
        $this->rewardValue = $rewardValue;
        $this->rewardType = $rewardType;
        $this->wageringMultiplier = $wageringMultiplier;

        if ($trigger->getValue() === Trigger::LOGIN && $rewardType->getValue() === RewardType::PERCENT_OF_DEPOSIT) {
            throw InvalidTrigger::mismatchedTriggerAndRewardType();
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getTrigger(): Trigger
    {
        return $this->trigger;
    }

    public function getRewardValue(): RewardValue
    {
        return $this->rewardValue;
    }

    public function getRewardType(): RewardType
    {
        return $this->rewardType;
    }

    public function getWageringMultiplier(): WageringMultiplier
    {
        return $this->wageringMultiplier;
    }
}
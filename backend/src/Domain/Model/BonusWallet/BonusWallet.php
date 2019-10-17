<?php

declare(strict_types=1);

namespace App\Domain\Model\BonusWallet;

use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\BonusWallet\Exception\InvalidCurrentValue;
use App\Domain\Model\BonusWallet\ValueObject\LeftWageringRequirements;
use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\CommonWallet;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;

class BonusWallet extends CommonWallet
{
    /** @var Bonus */
    private $bonus;

    /** @var LeftWageringRequirements */
    private $leftWageringRequirements;

    public function __construct(Uuid $uuid, InitialValue $initialValue, Player $player, Bonus $bonus)
    {
        $this->id = $uuid;
        $this->initialValue = $initialValue;
        $this->bonus = $bonus;
        $this->player = $player;

        $this->currency = new Currency(Currency::BNS);
        $this->currentValue = new CurrentValue($initialValue->getValue());
        $this->status = new Status(Status::ACTIVE);

        $this->leftWageringRequirements = LeftWageringRequirements::initialize(
            $initialValue, $bonus->getWageringMultiplier()
        );
    }

    public function getBonus(): Bonus
    {
        return $this->bonus;
    }

    public function getLeftWageringRequirements(): LeftWageringRequirements
    {
        return $this->leftWageringRequirements;
    }

    public function update(CurrentValue $currentValue): void
    {
        if ($currentValue->getValue() > $this->initialValue->getValue()) {
            throw InvalidCurrentValue::currentValueIsTooHigh($this->initialValue);
        }
        $this->currentValue = $currentValue;

        if ($currentValue->getValue() === 0) {
            $this->status = new Status(Status::DEPLETED);
        }
    }

    public function updateLeftWageringRequirements(Amount $betAmount): void
    {
        $this->leftWageringRequirements = $this->leftWageringRequirements->subtract($betAmount);

        if ($this->leftWageringRequirements->getValue() === 0) {
            $this->status = new Status(Status::WAGERED);
        }
    }
}
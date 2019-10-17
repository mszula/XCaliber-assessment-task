<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model\CommonWallet;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;

abstract class CommonWallet
{
    /** @var Uuid */
    protected $id;

    /** @var Currency */
    protected $currency;

    /** @var InitialValue */
    protected $initialValue;

    /** @var CurrentValue */
    protected $currentValue;

    /** @var Status */
    protected $status;

    /** @var Player */
    protected $player;

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getInitialValue(): InitialValue
    {
        return $this->initialValue;
    }

    public function getCurrentValue(): CurrentValue
    {
        return $this->currentValue;
    }

    public function getLeftSpace(): Amount
    {
        return new Amount($this->initialValue->getValue() - $this->getCurrentValue()->getValue());
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function addMoney(Amount $amount): void
    {
        $this->update(new CurrentValue(
            $this->getCurrentValue()->getValue() + $amount->getValue()
        ));
    }

    public function subtractMoney(Amount $amount): void
    {
        $this->update(new CurrentValue(
            $this->getCurrentValue()->getValue() - $amount->getValue()
        ));
    }

    public function zeroMoney()
    {
        $this->update(new CurrentValue(0));
    }

    abstract public function update(CurrentValue $currentValue): void;
}
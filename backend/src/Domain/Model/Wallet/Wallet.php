<?php

declare(strict_types=1);

namespace App\Domain\Model\Wallet;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\CommonWallet\CommonWallet;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Currency;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\Status;
use App\Domain\Shared\Model\Uuid;

class Wallet extends CommonWallet
{
    public function __construct(Uuid $uuid, InitialValue $initialValue, Player $player)
    {
        $this->id = $uuid;
        $this->initialValue = $initialValue;
        $this->player = $player;

        $this->currency = new Currency(Currency::EUR);
        $this->currentValue = new CurrentValue($initialValue->getValue());
        $this->status = new Status(Status::ACTIVE);
    }

    public function update(CurrentValue $currentValue): void
    {
        $this->currentValue = $currentValue;
    }
}
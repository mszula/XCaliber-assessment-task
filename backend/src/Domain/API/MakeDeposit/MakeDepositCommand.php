<?php

declare(strict_types=1);

namespace App\Domain\API\MakeDeposit;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\ValueObject\Amount;

class MakeDepositCommand
{
    /** @var Amount */
    private $amount;

    /** @var Player */
    private $player;

    public function __construct(int $amount, Player $player)
    {
        $this->amount = new Amount($amount);
        $this->player = $player;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\API\Spin;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\ValueObject\Amount;

class SpinCommand
{
    /** @var Amount */
    private $betAmount;

    /** @var Player */
    private $player;

    public function __construct(int $betAmount, Player $player)
    {
        $this->betAmount = new Amount($betAmount);
        $this->player = $player;
    }

    public function getBetAmount(): Amount
    {
        return $this->betAmount;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
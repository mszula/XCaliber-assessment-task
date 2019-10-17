<?php

declare(strict_types=1);

namespace App\Domain\API\SimulateLogin;

use App\Domain\Model\Player\Player;

class SimulateLoginCommand
{
    /** @var Player */
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Player;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Player\ViewModel\PlayersList;

interface PlayerReadModelRepositoryInterface
{
    public function getById(Uuid $uuid): Player;

    public function listPlayers(): PlayersList;
}
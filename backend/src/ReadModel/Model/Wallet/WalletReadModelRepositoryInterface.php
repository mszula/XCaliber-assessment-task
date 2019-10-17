<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Wallet;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Wallet\ViewModel\WalletsInfo;

interface WalletReadModelRepositoryInterface
{
    public function getWalletsInfo(Uuid $playerId): WalletsInfo;
}
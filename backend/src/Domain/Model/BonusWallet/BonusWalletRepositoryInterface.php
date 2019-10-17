<?php

declare(strict_types=1);

namespace App\Domain\Model\BonusWallet;

use App\Domain\Model\Player\Player;

interface BonusWalletRepositoryInterface
{
    /**
     * @param Player $player
     * @return array|BonusWallet[]
     */
    public function getActiveBonusWallets(Player $player): array;

    /**
     * @param Player $player
     * @return array|BonusWallet[]
     */
    public function getActiveBonusNotFullWallets(Player $player): array;

    public function save(BonusWallet $bonusWallet): void;
}
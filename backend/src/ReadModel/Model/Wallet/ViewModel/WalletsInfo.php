<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Wallet\ViewModel;

class WalletsInfo
{
    /** @var int */
    public $totalBalance;

    /** @var string */
    public $currency;

    /** @var int */
    public $realMoneyBalance;

    /** @var array|BonusWalletInfo[] */
    public $bonusWallets;

    public function __construct(
        int $totalBalance,
        string $currency,
        int $realMoneyBalance,
        BonusWalletInfo ...$bonusWallets
    )
    {
        $this->totalBalance = $totalBalance;
        $this->currency = $currency;
        $this->realMoneyBalance = $realMoneyBalance;
        $this->bonusWallets = $bonusWallets;
    }
}
<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Wallet\ViewModel;

class BonusWalletInfo
{
    /** @var int */
    public $balance;

    /** @var string */
    public $currency;

    public function __construct(int $balance, string $currency)
    {
        $this->balance = $balance;
        $this->currency = $currency;
    }
}
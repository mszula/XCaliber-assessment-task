<?php

declare(strict_types=1);

namespace App\Domain\Model\Wallet;

interface WalletRepositoryInterface
{
    public function save(Wallet $wallet): void;
}
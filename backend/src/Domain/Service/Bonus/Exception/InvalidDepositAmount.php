<?php

declare(strict_types=1);

namespace App\Domain\Service\Bonus\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidDepositAmount extends InvalidArgument
{
    public function lackOfDepositAmount()
    {
        return self('Deposit amount can\'t be null ');
    }
}
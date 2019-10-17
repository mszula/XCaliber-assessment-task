<?php

declare(strict_types=1);

namespace App\Domain\Factory\Exception;

use App\Domain\Exception\InvalidArgument;

class InvalidBonusType extends InvalidArgument
{
    public static function realMoneyType()
    {
        return new self('Invalid Bonus reward type. Percent of deposit or fixed amount allowed, but real money given.');
    }

    public static function lackOfDepositAmount()
    {
        return new self('Lack of deposit amount. It\'s required on bonus percent of deposit type.');
    }
}
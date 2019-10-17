<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Factory\Exception\InvalidBonusType;
use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\Player\Player;
use App\Domain\Service\Id\UuidGeneratorInterface;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\ValueObject\Amount;

class BonusWalletFactory
{
    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(Bonus $bonus, Player $player, ?Amount $depositAmount = null): BonusWallet
    {
        if ($bonus->getRewardType()->isRealMoney()) {
            throw InvalidBonusType::realMoneyType();
        }
        if ($bonus->getRewardType()->getValue() === RewardType::PERCENT_OF_DEPOSIT &&
            $depositAmount === null) {
            throw InvalidBonusType::lackOfDepositAmount();
        }

        switch ($bonus->getRewardType()->getValue()) {
            case RewardType::PERCENT_OF_DEPOSIT:
                $initialValue = (int)floor(
                    $depositAmount->getValue() * $bonus->getRewardValue()->getValue() / 100
                );
                break;
            case RewardType::BONUS_MONEY:
                $initialValue = $bonus->getRewardValue()->getValue();
                break;
            default:
                $initialValue = null;
        }

        return new BonusWallet(
            $this->uuidGenerator->generate(),
            new InitialValue($initialValue),
            $player,
            $bonus
        );
    }
}
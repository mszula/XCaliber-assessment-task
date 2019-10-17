<?php

namespace spec\App\Domain\Factory;

use App\Domain\API\Spin\Exception\UnableToSpin;
use App\Domain\Factory\BonusWalletFactory;
use App\Domain\Factory\Exception\InvalidBonusType;
use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\ValueObject\Name;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\Player\Player;
use App\Domain\Service\Id\UuidGeneratorInterface;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class BonusWalletFactorySpec extends ObjectBehavior
{
    function let(UuidGeneratorInterface $uuidGenerator)
    {
        $this->beConstructedWith($uuidGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BonusWalletFactory::class);
    }

    function it_is_create_bonus_wallet_with_percent_of_deposit(
        Player $player,
        UuidGeneratorInterface $uuidGenerator
    )
    {
        $bonus = $this->getBonus(RewardType::PERCENT_OF_DEPOSIT);

        $uuidGenerator->generate()->willReturn(new Uuid('6b68f62d-f6d9-4b6f-b178-fbb8c2854c04'));

        $bonusWallet = $this->create($bonus, $player, new Amount(10));
        $bonusWallet->shouldHaveType(BonusWallet::class);
        $bonusWallet->getInitialValue()->getValue()->shouldBe(5);
    }

    function it_is_create_bonus_wallet_with_fixed_value(
        Player $player,
        UuidGeneratorInterface $uuidGenerator
    )
    {
        $bonus = $this->getBonus(RewardType::BONUS_MONEY);

        $uuidGenerator->generate()->willReturn(new Uuid('6b68f62d-f6d9-4b6f-b178-fbb8c2854c04'));

        $bonusWallet = $this->create($bonus, $player, new Amount(10));
        $bonusWallet->shouldHaveType(BonusWallet::class);
        $bonusWallet->getInitialValue()->getValue()->shouldBe(50);
    }

    function it_is_should_throw_as_exception_due_to_real_money_bonus(
        Player $player
    )
    {
        $bonus = $this->getBonus(RewardType::REAL_MONEY);
        $this->shouldThrow(InvalidBonusType::realMoneyType())
            ->during('create', [$bonus, $player, new Amount(10)]);
    }

    function it_is_should_throw_as_exception_due_to_percent_of_deposit_and_lack_of_amount(
        Player $player
    )
    {
        $bonus = $this->getBonus(RewardType::PERCENT_OF_DEPOSIT);
        $this->shouldThrow(InvalidBonusType::lackOfDepositAmount())
            ->during('create', [$bonus, $player]);
    }

    private function getBonus(string $rewardType)
    {
        return new Bonus(
            new Uuid('0de36b41-ff5f-4da4-bbab-c9501b346272'),
            new Name('test'),
            new Trigger(Trigger::DEPOSIT),
            new RewardValue(50),
            new RewardType($rewardType),
            new WageringMultiplier(10)
        );
    }
}

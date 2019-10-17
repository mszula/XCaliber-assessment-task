<?php

namespace spec\App\Domain\Service\Bonus;

use App\Domain\Factory\BonusWalletFactory;
use App\Domain\Model\Bonus\Bonus;
use App\Domain\Model\Bonus\BonusRepositoryInterface;
use App\Domain\Model\Bonus\ValueObject\Name;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Bonus\TriggerBonusResolver;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TriggerBonusResolverSpec extends ObjectBehavior
{
    function let(
        BonusRepositoryInterface $bonusRepository,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository,
        BonusWalletFactory $bonusWalletFactory
    )
    {
        $this->beConstructedWith($bonusRepository, $walletRepository, $bonusWalletRepository, $bonusWalletFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TriggerBonusResolver::class);
    }

    function it_is_resolve_bonuses_with_bonus_wallet(
        Player $player,
        BonusRepositoryInterface $bonusRepository,
        BonusWalletFactory $bonusWalletFactory,
        BonusWalletRepositoryInterface $bonusWalletRepository
    )
    {
        $trigger = new Trigger(Trigger::DEPOSIT);
        $bonus = new Bonus(
            new Uuid('0de36b41-ff5f-4da4-bbab-c9501b346272'),
            new Name('test'),
            $trigger,
            new RewardValue(50),
            new RewardType(RewardType::BONUS_MONEY),
            new WageringMultiplier(10)
        );
        $deposit = new Amount(10);

        $bonusRepository->getAllForTrigger($trigger)->willReturn([$bonus]);
        $bonusWalletFactory->create($bonus, $player, $deposit)->shouldBeCalledOnce();
        $bonusWalletRepository->save(Argument::type(BonusWallet::class))->shouldBeCalledOnce();

        $this->action($trigger, $player, $deposit)->shouldBeNull();
    }

    function it_is_resolve_bonuses_with_real_money(
        Player $player,
        Wallet $wallet,
        BonusRepositoryInterface $bonusRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $trigger = new Trigger(Trigger::DEPOSIT);
        $bonus = new Bonus(
            new Uuid('0de36b41-ff5f-4da4-bbab-c9501b346272'),
            new Name('test'),
            $trigger,
            new RewardValue(50),
            new RewardType(RewardType::REAL_MONEY),
            new WageringMultiplier(10)
        );
        $deposit = new Amount(10);

        $player->getRealMoneyWallet()->willReturn($wallet);
        $wallet->addMoney(new Amount($bonus->getRewardValue()->getValue()))->shouldBeCalledOnce();
        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $bonusRepository->getAllForTrigger($trigger)->willReturn([$bonus]);

        $this->action($trigger, $player, $deposit)->shouldBeNull();
    }
}

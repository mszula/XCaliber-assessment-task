<?php

namespace spec\App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Spin\LooseAction;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use App\Domain\Shared\Model\Uuid;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class LooseActionSpec extends ObjectBehavior
{
    function let(
        BonusWalletRepositoryInterface $bonusWalletRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->beConstructedWith($bonusWalletRepository, $walletRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LooseAction::class);
    }

    function it_is_subtract_money_from_real_money_wallet_only(
        Player $player,
        Wallet $wallet,
        WalletRepositoryInterface $walletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $wallet->getCurrentValue()->willReturn(new CurrentValue(100));
        $wallet->subtractMoney(new Amount(10))->shouldBeCalledOnce();

        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $this->loose(new Amount(10), $player)->shouldBeNull();
    }

    function it_is__subtract_money_from_real_money_wallet_and_bonus_wallets(
        Player $player,
        Wallet $wallet,
        BonusWallet $bonusWallet1,
        BonusWallet $bonusWallet2,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $wallet->getCurrentValue()->willReturn(new CurrentValue(1));
        $wallet->zeroMoney()->shouldBeCalledOnce();

        $bonusWallet1->getCurrentValue()->willReturn(new CurrentValue(7));
        $bonusWallet1->zeroMoney()->shouldBeCalledOnce();

        $bonusWallet2->getCurrentValue()->willReturn(new CurrentValue(100));
        $bonusWallet2->subtractMoney(new Amount(2))->shouldBeCalledOnce();

        $bonusWalletRepository->getActiveBonusWallets($player)->willReturn([
            $bonusWallet1,
            $bonusWallet2,
        ]);
        $walletRepository->save($wallet)->shouldBeCalledOnce();
        $bonusWalletRepository->save($bonusWallet1)->shouldBeCalledOnce();
        $bonusWalletRepository->save($bonusWallet2)->shouldBeCalledOnce();

        $this->loose(new Amount(10), $player)->shouldBeNull();
    }
}

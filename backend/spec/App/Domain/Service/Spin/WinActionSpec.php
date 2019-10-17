<?php

namespace spec\App\Domain\Service\Spin;

use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\BonusWallet\BonusWalletRepositoryInterface;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Model\Wallet\WalletRepositoryInterface;
use App\Domain\Service\Spin\WinAction;
use App\Domain\Shared\Model\CommonWallet\ValueObject\CurrentValue;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class WinActionSpec extends ObjectBehavior
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
        $this->shouldHaveType(WinAction::class);
    }

    function it_is_add_money_to_real_money_wallet_only(
        Player $player,
        Wallet $wallet,
        WalletRepositoryInterface $walletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $wallet->getCurrentValue()->willReturn(new CurrentValue(100));
        $wallet->addMoney(new Amount(10))->shouldBeCalledOnce();

        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $this->win(new Amount(10), $player)->shouldBeNull();
    }

    function it_is_add_money_to_real_money_wallet_and_bonus_wallets(
        Player $player,
        Wallet $wallet,
        BonusWallet $bonusWallet1,
        BonusWallet $bonusWallet2,
        WalletRepositoryInterface $walletRepository,
        BonusWalletRepositoryInterface $bonusWalletRepository
    )
    {
        $player->getRealMoneyWallet()->willReturn($wallet);
        $wallet->getCurrentValue()->willReturn(new CurrentValue(20));
        $wallet->addMoney(new Amount(5))->shouldBeCalledOnce();

        $bonusWallet1->getLeftSpace()->willReturn(new Amount(2));
        $bonusWallet2->getLeftSpace()->willReturn(new Amount(3));
        $bonusWallet1->addMoney(new Amount(2));
        $bonusWallet2->addMoney(new Amount(3));
        $bonusWalletRepository->getActiveBonusNotFullWallets($player)->willReturn([
            $bonusWallet1,
            $bonusWallet2,
        ]);
        $bonusWalletRepository->save($bonusWallet1)->shouldBeCalledOnce();
        $bonusWalletRepository->save($bonusWallet2)->shouldBeCalledOnce();

        $walletRepository->save($wallet)->shouldBeCalledOnce();

        $this->win(new Amount(30), $player)->shouldBeNull();
    }
}

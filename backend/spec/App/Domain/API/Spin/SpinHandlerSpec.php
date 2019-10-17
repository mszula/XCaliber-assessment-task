<?php

namespace spec\App\Domain\API\Spin;

use App\Domain\API\Spin\Exception\UnableToSpin;
use App\Domain\API\Spin\SpinCommand;
use App\Domain\API\Spin\SpinHandler;
use App\Domain\Model\Player\Player;
use App\Domain\Service\Player\TotalBalanceCalculator;
use App\Domain\Service\Spin\LooseAction;
use App\Domain\Service\Spin\RandomGenerator;
use App\Domain\Service\Spin\WageringRequirementsCalculator;
use App\Domain\Service\Spin\WinAction;
use App\Domain\Shared\ValueObject\Amount;
use PhpSpec\ObjectBehavior;

class SpinHandlerSpec extends ObjectBehavior
{
    function let(
        TotalBalanceCalculator $totalBalanceCalculator,
        WageringRequirementsCalculator $wageringRequirementsCalculator,
        WinAction $winAction,
        LooseAction $looseAction,
        RandomGenerator $randomGenerator
    )
    {
        $this->beConstructedWith($totalBalanceCalculator, $wageringRequirementsCalculator, $winAction, $looseAction, $randomGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SpinHandler::class);
    }

    function it_is_spin_and_win(
        Player $player,
        TotalBalanceCalculator $totalBalanceCalculator,
        WinAction $winAction,
        RandomGenerator $randomGenerator,
        WageringRequirementsCalculator $wageringRequirementsCalculator
    )
    {
        $command = new SpinCommand(10, $player->getWrappedObject());

        $totalBalanceCalculator->calculate($player)->willReturn(new Amount(10));
        $randomGenerator->rollACoin()->willReturn(true);
        $winAction->win($command->getBetAmount(), $player)->shouldBeCalledOnce();
        $wageringRequirementsCalculator->calculate($command->getBetAmount(), $player)->shouldBeCalledOnce();

        $this->handle($command)->shouldBeNull();
    }

    function it_is_spin_and_loose(
        Player $player,
        TotalBalanceCalculator $totalBalanceCalculator,
        LooseAction $looseAction,
        RandomGenerator $randomGenerator,
        WageringRequirementsCalculator $wageringRequirementsCalculator
    )
    {
        $command = new SpinCommand(10, $player->getWrappedObject());

        $totalBalanceCalculator->calculate($player)->willReturn(new Amount(10));
        $randomGenerator->rollACoin()->willReturn(false);
        $looseAction->loose($command->getBetAmount(), $player)->shouldBeCalledOnce();
        $wageringRequirementsCalculator->calculate($command->getBetAmount(), $player)->shouldBeCalledOnce();

        $this->handle($command)->shouldBeNull();
    }

    function it_should_throw_to_high_bet_exception(
        Player $player,
        TotalBalanceCalculator $totalBalanceCalculator
    )
    {
        $command = new SpinCommand(10, $player->getWrappedObject());

        $totalAmount = new Amount(9);
        $totalBalanceCalculator->calculate($player)->willReturn($totalAmount);

        $this->shouldThrow(UnableToSpin::betAmountIsTooHigh($totalAmount))
            ->during('handle', [$command]);
    }
}

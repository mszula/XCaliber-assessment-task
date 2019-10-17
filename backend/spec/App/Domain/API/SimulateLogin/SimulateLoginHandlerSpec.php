<?php

namespace spec\App\Domain\API\SimulateLogin;

use App\Domain\API\SimulateLogin\SimulateLoginCommand;
use App\Domain\API\SimulateLogin\SimulateLoginHandler;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Player\Player;
use App\Domain\Service\Bonus\TriggerBonusResolver;
use PhpSpec\ObjectBehavior;

class SimulateLoginHandlerSpec extends ObjectBehavior
{
    function let(TriggerBonusResolver $triggerBonusResolver)
    {
        $this->beConstructedWith($triggerBonusResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SimulateLoginHandler::class);
    }

    function it_is_simulate_login_action(Player $player, TriggerBonusResolver $triggerBonusResolver)
    {
        $triggerBonusResolver->action(new Trigger(Trigger::LOGIN), $player)->shouldBeCalled();

        $command = new SimulateLoginCommand($player->getWrappedObject());

        $this->handle($command)->shouldBeNull();
    }
}

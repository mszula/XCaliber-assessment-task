<?php

declare(strict_types=1);

namespace App\Domain\API\SimulateLogin;

use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Service\Bonus\TriggerBonusResolver;

class SimulateLoginHandler
{
    /** @var TriggerBonusResolver */
    private $triggerBonusResolver;

    public function __construct(TriggerBonusResolver $triggerBonusResolver)
    {
        $this->triggerBonusResolver = $triggerBonusResolver;
    }

    public function handle(SimulateLoginCommand $command): void
    {
        $this->triggerBonusResolver->action(
            new Trigger(Trigger::LOGIN),
            $command->getPlayer()
        );
    }
}
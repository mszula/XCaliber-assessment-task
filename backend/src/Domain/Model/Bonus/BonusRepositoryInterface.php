<?php

declare(strict_types=1);

namespace App\Domain\Model\Bonus;

use App\Domain\Model\Bonus\ValueObject\Trigger;

interface BonusRepositoryInterface
{
    /**
     * @param Trigger $trigger
     * @return Bonus[]
     */
    public function getAllForTrigger(Trigger $trigger): array;
}
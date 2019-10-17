<?php

declare(strict_types=1);

namespace App\Domain\Service\Spin;

class RandomGenerator
{
    public function rollACoin(): bool
    {
        return (bool)random_int(0, 1);
    }
}
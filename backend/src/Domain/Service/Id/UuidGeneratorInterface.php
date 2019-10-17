<?php

declare(strict_types=1);

namespace App\Domain\Service\Id;

use App\Domain\Shared\Model\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): Uuid;
}
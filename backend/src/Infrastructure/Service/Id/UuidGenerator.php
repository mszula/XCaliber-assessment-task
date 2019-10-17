<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Id;

use App\Domain\Service\Id\UuidGeneratorInterface as UuidGeneratorInterface;
use App\Domain\Shared\Model\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): Uuid
    {
        return new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }
}
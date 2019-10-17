<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Player\Exception;

use App\ReadModel\Exception\ResourceNotFound;

class PlayerNotFound extends ResourceNotFound
{
    public static function notFound(string $id): self
    {
        return new self(sprintf('Player not found for key %s', $id));
    }
}
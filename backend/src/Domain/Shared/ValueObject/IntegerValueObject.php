<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

abstract class IntegerValueObject
{
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
